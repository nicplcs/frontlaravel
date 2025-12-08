<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invex - Interfaz</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #101011ff;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #1e293b;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .logo {
            padding: 0 20px 30px;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            width: 30px;
            height: 30px;
            background: #3b82f6;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-item {
            padding: 15px 20px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #94a3b8;
            text-decoration: none;
        }

        .menu-item:hover {
            background: #334155;
            color: white;
        }

        .menu-item.active {
            background: #334155;
            color: white;
            border-left: 3px solid #3b82f6;
        }

        .menu-icon {
            width: 20px;
            height: 20px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            background: #161717ff;
        }

        /* Header */
        .header {
            background: #1e293b;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .search-bar {
            flex: 1;
            max-width: 500px;
            position: relative;
        }

        .search-bar input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: none;
            border-radius: 8px;
            background: #334155;
            color: white;
            outline: none;
        }

        .search-bar input::placeholder {
            color: #fefefeff;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-icon, .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
        }

        .notification-icon {
            background: #ffffffff;
        }

        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            width: 18px;
            height: 18px;
            background: #f60000ff;
            border-radius: 50%;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-avatar {
            background: #000000ff;
            font-weight: 600;
        }

        /* Dashboard Content */
        .dashboard-content {
            padding: 40px;
        }

        .dashboard-title {
            font-size: 32px;
            color: #ffffffff;
            margin-bottom: 30px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            padding: 30px;
            border-radius: 16px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .stat-card.blue { background: linear-gradient(135deg, #0073ffff, #4771bbff); }
        .stat-card.orange { background: linear-gradient(135deg, #ff0b0bff, #b44040ff); }
        .stat-card.green { background: linear-gradient(135deg, #00ff99ff, #37b271ff); }
        .stat-card.purple { background: linear-gradient(135deg, #c4b5fd, #833a97ff); }

        .stat-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        /* Charts Section */
        .charts-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            margin-bottom: 40px;
        }

        .chart-card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .chart-title {
            font-size: 18px;
            color: #1e293b;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .chart-placeholder {
            height: 300px;
            background: #f8fafc;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
        }

        /* Critical Products List */
        .product-list {
            list-style: none;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-name {
            color: #475569;
            font-size: 14px;
        }

        .product-quantity {
            font-weight: 600;
            color: #1e293b;
        }

        .product-quantity.low {
            color: #ef4444;
        }

        .product-quantity.medium {
            color: #f59e0b;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .charts-section {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <span>Invex</span>
            </div>
            <a href="#" class="menu-item active">
                <span class="menu-icon"></span>
                <span>Dashboard</span>
            </a>
            <a href="#" class="menu-item">
                <span class="menu-icon"></span>
                <span>Movimientos</span>
            </a>
            <a href="#" class="menu-item">
                <span class="menu-icon"></span>
                <span>Productos</span>
            </a>
            <a href="#" class="menu-item">
                <span class="menu-icon"></span>
                <span>Usuarios</span>
            </a>
            <a href="#" class="menu-item">
                <span class="menu-icon"></span>
                <span>Cerrar Sesión</span>
            </a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="search-bar">
                    <span class="search-icon">🔍</span>
                    <input type="text" placeholder="Buscar productos, movimientos...">
                </div>
                <div class="header-right">
                    <div class="notification-icon">
                        🔔
                        <span class="notification-badge">3</span>
                    </div>
                    <div class="user-avatar">JA</div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <h1 class="dashboard-title">Dashboard</h1>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card blue">
                        <div class="stat-label">Stock Total</div>
                        <div class="stat-value"></div>
                        <div class="stat-icon"></div>
                    </div>
                    <div class="stat-card orange">
                        <div class="stat-label">Productos Bajo</div>
                        <div class="stat-value"></div>
                        <div class="stat-icon"></div>
                    </div>
                    <div class="stat-card green">
                        <div class="stat-label">Últimos Movimientos</div>
                        <div class="stat-value"></div>
                        <div class="stat-icon"></div>
                    </div>
                    <div class="stat-card purple">
                        <div class="stat-label">Usuarios Activos</div>
                        <div class="stat-value"></div>
                        <div class="stat-icon"></div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="charts-section">
                    <div class="chart-card">
                        <h2 class="chart-title">ENTRADAS vs SALIDAS (ÚLTIMO MES)</h2>
                        <div class="chart-placeholder">
                        </div>
                    </div>
                    <div class="chart-card">
                        <h2 class="chart-title">PRODUCTOS CRÍTICOS</h2>
                        <ul class="product-list">
                            <li class="product-item">
                                <span class="product-name"></span>
                                <span class="product-quantity low"></span>
                            </li>
                            <li class="product-item">
                                <span class="product-name"></span>
                                <span class="product-quantity low"></span>
                            </li>
                            <li class="product-item">
                                <span class="product-name"></span>
                                <span class="product-quantity low"></span>
                            </li>
                            <li class="product-item">
                                <span class="product-name"></span>
                                <span class="product-name"></span>
                            </li>
                            <li class="product-item">
                                <span class="product-name"></span>
                                <span class="product-quantity low"></span>
                            </li>
                            <li class="product-item">
                                <span class="product-name"></span>
                                <span class="product-quantity low"></span>
                            </li>
                            <li class="product-item">
                                <span class="product-name"></span>
                                <span class="product-quantity medium"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        
        // Manejo de navegación
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>