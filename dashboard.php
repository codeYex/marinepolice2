<?php
session_start();
include 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: index.php');
    exit();
}

include 'includes/dash_header.php';
?>


<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>
<!-- Sidebar -->


        <!-- Main Content -->
        <div class="main-content">
            <h1>Welcome Admin</h1>
            <div class="cards">
                <!-- Total Users Card -->
                <div class="card total-users">
                    <h2>Total Personnel</h2>
                    <p>5605</p>
                </div>

                <!-- Active Users Card -->
                <div class="card active-users">
                    <h2>Promotions</h2>
                    <p>407</p>
                </div>

                <div class="card totals">
                    <h2>Unverified</h2>
                    <p>9005</p>
                </div>

                <!-- Active Users Card -->
                <div class="card actives">
                    <h2>Active Missions</h2>
                    <p>397</p>
                </div>
            </div>
            
    <!-- Charts -->
    <div class="charts">
                <!-- Row 1 -->
                <div class="chart-row">
                    <div class="chart-container">
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                    <div class="chart-container">
                        <canvas id="userActivityChart"></canvas>
                    </div>
                </div>

                
                <div class="chart-row">
                    <div class="chart-container">
                        <canvas id="userStatusChart"></canvas>
                    </div>
                    <div class="chart-container">
                        <canvas id="userLocationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        
        const userGrowthChart = new Chart(document.getElementById('userGrowthChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'User Growth',
                    data: [1000, 2000, 3000, 8000, 5000, 5605, 6700],
                    borderColor: '#1DB954',
                    backgroundColor: 'rgba(76, 175, 80, 0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'User Growth Over Time'
                    }
                }
            }
        });

        
        const userActivityChart = new Chart(document.getElementById('userActivityChart'), {
            type: 'bar',
            data: {
                labels: ['Active', 'Inactive'],
                datasets: [{
                    label: 'User Activity',
                    data: [5507, 3028],
                    backgroundColor: ['#2196F3', '#FF5252'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'User Activity'
                    }
                }
            }
        });

        // 
        const userStatusChart = new Chart(document.getElementById('userStatusChart'), {
            type: 'pie',
            data: {
                labels: ['Active Users', 'Inactive Users'],
                datasets: [{
                    label: 'User Status',
                    data: [4304 , 3434],
                    backgroundColor: ['#4CAF50', '#FF5252'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'User Status'
                    }
                }
            }
        });

        // 
        const userLocationChart = new Chart(document.getElementById('userLocationChart'), {
            type: 'doughnut',
            data: {
                labels: ['North', 'South', 'East', 'West'],
                datasets: [{
                    label: 'User Location',
                    data: [1500, 2000, 1000, 1105],
                    backgroundColor: ['#FF9800', '#9C27B0', '#00BCD4', '#8BC34A'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'User Location Distribution'
                    }
                }
            }
        });
    </script>
        </div>
        
    </div>

</body>
</html>

<?php include 'includes/footer.php'; ?>