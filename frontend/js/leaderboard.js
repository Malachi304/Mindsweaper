function loadLeaderboard() {
    const leaderboardDiv = document.getElementById('leaderboard-list');

    // Display a loading message while fetching data
    leaderboardDiv.innerHTML = 'Loading...';

    fetch('../../backend/leaderboard.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                leaderboardDiv.innerHTML = ''; // Clear previous data

                const table = document.createElement('table');
                table.innerHTML = `
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>Score</th>
                    </tr>
                `;

                data.leaderboard.forEach((entry, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${entry.name}</td>
                        <td>${entry.score}</td>
                    `;
                    table.appendChild(row);
                });

                leaderboardDiv.appendChild(table);
            } else {
                leaderboardDiv.innerHTML = '<p>No leaderboard data available.</p>';
            }
        })
        .catch(error => {
            leaderboardDiv.innerHTML = '<p style="color:red;">Error loading leaderboard. Please try again later.</p>';
            console.error("Error loading leaderboard:", error);
        });
}

document.addEventListener('DOMContentLoaded', loadLeaderboard);
