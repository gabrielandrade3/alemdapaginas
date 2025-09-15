document.addEventListener('DOMContentLoaded', function () {
    const tooltipTarget = document.querySelector('.username-tooltip');

    let tooltip = document.querySelector('.custom-tooltip');
    if (!tooltip) {
        tooltip = document.createElement('div');
        tooltip.classList.add('custom-tooltip');
        document.body.appendChild(tooltip);
    }


    if (tooltipTarget) {
        const tooltip = document.createElement('div');
        tooltip.classList.add('custom-tooltip');
        tooltip.innerText = tooltipTarget.getAttribute('data-username');
        document.body.appendChild(tooltip);

        

        function positionTooltip() {
            const rect = tooltipTarget.getBoundingClientRect();
            const scrollY = window.scrollY || window.pageYOffset;
            const scrollX = window.scrollX || window.pageXOffset;

            const tooltipWidth = tooltip.offsetWidth;
            const tooltipHeight = tooltip.offsetHeight;

            const left = rect.left + scrollX + (rect.width / 2) - (tooltipWidth / 2);
            const top = rect.top + scrollY - tooltipHeight - 8;

            tooltip.style.left = `${left}px`;
            tooltip.style.top = `${top}px`;
        }

        tooltipTarget.addEventListener('mouseenter', function () {
            positionTooltip();
            tooltip.classList.add('visible');
        });

        tooltipTarget.addEventListener('mousemove', positionTooltip);

        tooltipTarget.addEventListener('mouseleave', function () {
            tooltip.classList.remove('visible');
        });
    }
});
