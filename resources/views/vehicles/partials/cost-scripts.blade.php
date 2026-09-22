<script>
    document.addEventListener('DOMContentLoaded', () => {
        const chartCanvas = document.getElementById('serviceCostChart');
        const currencySelect = document.getElementById('currencySelect');
        const yearSelect = document.getElementById('costYearSelect');
        const summaryPeriod = document.getElementById('summaryPeriod');
        const summaryYear = document.getElementById('summaryYear');
        const summaryBody = document.getElementById('costSummaryBody');
        const summaryTotal = document.getElementById('summaryTotal');
        const summaryPeriodLabel = document.getElementById('summaryPeriodLabel');

        if (!chartCanvas || typeof Chart === 'undefined') return;

        const monthsShort = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const monthsLong = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const currencyConfig = {
            HUF: { locale: 'hu-HU', currency: 'HUF' },
            EUR: { locale: 'de-DE', currency: 'EUR' },
            USD: { locale: 'en-US', currency: 'USD' },
            GBP: { locale: 'en-GB', currency: 'GBP' }
        };
        let serviceCostChart = null;

        const formatCurrency = (value, currency) => {
            const config = currencyConfig[currency] ?? currencyConfig.HUF;
            return new Intl.NumberFormat(config.locale, {
                style: 'currency',
                currency: config.currency,
                maximumFractionDigits: 2
            }).format(Number(value) || 0);
        };

        const createSummaryRow = (label, value, currency) => {
            const row = document.createElement('tr');
            const periodCell = document.createElement('td');
            const costCell = document.createElement('td');
            periodCell.textContent = label;
            costCell.className = 'text-end fw-semibold';
            costCell.textContent = formatCurrency(value, currency);
            row.append(periodCell, costCell);
            return row;
        };

        async function loadServiceCosts(currency, year) {
            try {
                const url = new URL("{{ route('vehicles.service-costs', $vehicle) }}", window.location.origin);
                url.searchParams.set('currency', currency);
                url.searchParams.set('year', year);

                const response = await fetch(url);
                if (!response.ok) throw new Error(`HTTP ${response.status}`);

                const result = await response.json();
                const monthly = result.monthly ?? [];
                const serviceCosts = monthly.map((item) => Number(item.service ?? 0));
                const fuelingCosts = monthly.map((item) => Number(item.fueling ?? 0));
                const totalCosts = monthly.map((item) => Number(item.total ?? 0));
                const totalVehicleCost = totalCosts.reduce((sum, cost) => sum + cost, 0);
                const themeStyles = getComputedStyle(document.documentElement);
                const chartTextColor = themeStyles.getPropertyValue('--fleet-muted').trim() || '#697386';
                const chartGridColor = themeStyles.getPropertyValue('--fleet-line').trim() || '#edf0f5';

                document.getElementById('totalVehicleCost').textContent = formatCurrency(totalVehicleCost, result.currency);
                serviceCostChart?.destroy();

                serviceCostChart = new Chart(chartCanvas, {
                    type: 'line',
                    data: {
                        labels: monthsShort,
                        datasets: [
                            {
                                label: `Service (${result.currency})`,
                                data: serviceCosts,
                                borderColor: '#3157d5',
                                backgroundColor: 'rgba(49, 87, 213, .08)',
                                borderWidth: 2,
                                tension: .35,
                                fill: true,
                                pointRadius: 3,
                                pointHoverRadius: 6
                            },
                            {
                                label: `Fueling (${result.currency})`,
                                data: fuelingCosts,
                                borderColor: '#16a085',
                                backgroundColor: 'rgba(22, 160, 133, .06)',
                                borderWidth: 2,
                                tension: .35,
                                fill: true,
                                pointRadius: 3,
                                pointHoverRadius: 6
                            },
                            {
                                label: `Total (${result.currency})`,
                                data: totalCosts,
                                borderColor: '#e79a22',
                                borderWidth: 3,
                                borderDash: [6, 5],
                                tension: .35,
                                fill: false,
                                pointRadius: 3,
                                pointHoverRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { intersect: false, mode: 'index' },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { color: chartTextColor, usePointStyle: true, boxWidth: 8, padding: 18 }
                            },
                            tooltip: {
                                callbacks: {
                                    label: (context) => `${context.dataset.label}: ${formatCurrency(context.parsed.y, result.currency)}`
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                border: { display: false },
                                ticks: { color: chartTextColor }
                            },
                            y: {
                                beginAtZero: true,
                                border: { display: false },
                                grid: { color: chartGridColor },
                                ticks: {
                                    color: chartTextColor,
                                    callback: (value) => formatCurrency(value, result.currency)
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Unable to load vehicle costs:', error);
                document.getElementById('totalVehicleCost').textContent = 'Unavailable';
            }
        }

        async function loadCostSummary(currency, year) {
            summaryBody.innerHTML = '<tr><td colspan="2" class="text-center text-muted py-4">Loading...</td></tr>';

            try {
                const url = new URL("{{ route('vehicles.service-cost-summary', $vehicle) }}", window.location.origin);
                url.searchParams.set('currency', currency);
                url.searchParams.set('year', year);

                const response = await fetch(url);
                if (!response.ok) throw new Error(`HTTP ${response.status}`);

                const result = await response.json();
                const isMonthly = summaryPeriod.value === 'monthly';
                const rows = isMonthly ? (result.monthly ?? []) : (result.yearly ?? []);
                let total = 0;

                summaryPeriodLabel.textContent = isMonthly ? `Monthly costs · ${result.year}` : 'Yearly costs';
                summaryBody.innerHTML = '';

                rows.forEach((item, index) => {
                    const cost = Number(item.total ?? 0);
                    total += cost;
                    summaryBody.appendChild(createSummaryRow(isMonthly ? monthsLong[index] : item.year, cost, result.currency));
                });

                if (rows.length === 0) {
                    summaryBody.innerHTML = '<tr><td colspan="2" class="text-center text-muted py-4">No cost data.</td></tr>';
                }

                summaryTotal.textContent = formatCurrency(total, result.currency);
            } catch (error) {
                console.error('Unable to load cost summary:', error);
                summaryBody.innerHTML = '<tr><td colspan="2" class="text-center text-danger py-4">Unable to load cost summary.</td></tr>';
                summaryTotal.textContent = '—';
            }
        }

        const refreshSummary = () => loadCostSummary(currencySelect.value, summaryYear.value);
        loadServiceCosts(currencySelect.value, yearSelect.value);
        refreshSummary();

        currencySelect.addEventListener('change', () => {
            loadServiceCosts(currencySelect.value, yearSelect.value);
            refreshSummary();
        });
        yearSelect.addEventListener('change', () => loadServiceCosts(currencySelect.value, yearSelect.value));
        summaryPeriod.addEventListener('change', refreshSummary);
        summaryYear.addEventListener('change', refreshSummary);
        window.addEventListener('fleet:theme-changed', () => {
            loadServiceCosts(currencySelect.value, yearSelect.value);
        });
    });
</script>
