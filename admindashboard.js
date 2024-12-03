function loadContent(page) {
    const mainContent = document.getElementById('mainContent');
    
    if (page === 'registers') {
        fetch('registers.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                mainContent.innerHTML = html;
            })
            .catch(error => {
                console.error('Error:', error);
                mainContent.innerHTML = 'Error loading content: ' + error;
            });
    } else if (page === 'admin') {
        mainContent.innerHTML = `
            <div class="greetings">
                <h2>Welcome, ${window.adminName}!</h2><br>
                <p>Here is an overview of your key management</p><br>
                <p>tasks for today. You can manage users, track</p><br>
                <p>borrowed items, and check recent activities</p><br>
                <p>from this dashboard.</p>
                <img src="Images/work.png" class="image">

                <div class="statistics">
                    <h2>STATISTICS</h2>
                    <div class="stat-item">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <h3>Registered Users</h3>
                        <p>${window.totalUsers}</p>
                    </div>
                    <div class="stat-item">
                        <i class="fa-solid fa-key"></i>
                        <h3>Items Borrowed</h3>
                        <p>${window.totalBorrowed}</p>
                    </div>
                    <div class="stat-item">
                        <i class="fa-solid fa-hand-holding-hand"></i>
                        <h3>Returned Key</h3>
                        <p>${window.totalReturned}</p>
                    </div>
                </div>
            </div>
        `;
    } else if (page === 'records') {
        fetch('records.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                mainContent.innerHTML = `
                    <div class="registers">
                        <h1>KEY RECORDS</h1>
                        <table>
                            <thead>
                                <tr>
                                    <th>NAME</th>
                                    <th>ID NUMBER</th>
                                    <th>SECTION</th>
                                    <th>KEY NAME</th>
                                    <th>BORROWED AT</th>
                                    <th>RETURNED AT</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${html}
                            </tbody>
                        </table>
                    </div>
                `;
            })
            .catch(error => {
                console.error('Error:', error);
                mainContent.innerHTML = 'Error loading records';
            });
    }
}

// Load admin content by default when page loads
document.addEventListener('DOMContentLoaded', () => {
    loadContent('admin');
});
