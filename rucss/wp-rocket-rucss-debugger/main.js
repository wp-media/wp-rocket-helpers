(function() {
    async function executeCron(cronURL) {
        console.log(`Running the cron: ${cronURL}`);
        const doingCronStatus = document.getElementById('doing-cron-status');
        doingCronStatus.innerText = ': ...';
        try {
            const response = await fetch(cronURL);
            if (response.status === 200) {
                doingCronStatus.innerText = ': ✔';
            console.log(`Cron: Success..`);
            } else {
                doingCronStatus.innerText = ` Status: ${response.status}`;
                console.warn(`Cron failed to run. Status: ${response.status}`);
            }
        } catch (error) {
            doingCronStatus.innerText = ': ❌ (Check the console)';
            console.error(`Cron failed to run (URL: ${cronURL}):
            ${String(error)}`);
        }
    }
    const doingCronButton = document.getElementById('doing-cron-button');
    const cronURL = doingCronButton.href;
    doingCronButton.addEventListener('click', (e) => {
        e.preventDefault();
        executeCron(cronURL);
    });
})();