
<?php /* index.php */ ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Expense Tracker Dashboard | Financial Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
  <style>
    :root {
      --primary: #2dd4bf; /* Teal */
      --primary-light: #5eead4;
      --primary-dark: #0f766e;
      --secondary: #f472b6; /* Coral */
      --secondary-light: #f9a8d4;
      --secondary-dark: #db2777;
      --danger: #ef4444;
      --danger-light: #f87171;
      --danger-dark: #dc2626;
      --warning: #f59e0b;
      --warning-light: #fbbf24;
      --warning-dark: #d97706;
      --info: #3b82f6;
      --info-light: #60a5fa;
      --info-dark: #2563eb;
      --dark: #111827;
      --dark-light: #1f2937;
      --light: #f9fafb;
      --gray: #6b7280;
      --gray-light: #d1d5db;
      --border-radius: 0.75rem;
      --border-radius-sm: 0.375rem;
      --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
      --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    body {
      font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
      color: var(--dark);
      min-height: 100vh;
      line-height: 1.6;
      font-size: 16px;
    }
    
    .container {
      max-width: 1600px;
      padding: 2.5rem 2rem;
      margin: 0 auto;
    }
    
    /* Typography */
    h1, h2, h3, h4, h5, h6 {
      font-weight: 700;
      line-height: 1.2;
      color: var(--dark);
    }
    
    .text-muted {
      color: var(--gray) !important;
    }
    
    /* Cards */
    .card {
      border: none;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      transition: var(--transition);
      background-color: white;
      overflow: hidden;
    }
    
    .card:hover {
      transform: translateY(-8px);
      box-shadow: var(--shadow-md);
    }
    
    .card-header {
      background-color: rgba(255, 255, 255, 0.95);
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      font-weight: 600;
      padding: 1.5rem;
      display: flex;
      align-items: center;
      font-size: 1.1rem;
    }
    
    .card-header i {
      margin-right: 0.75rem;
      font-size: 1.2em;
      color: var(--primary-dark);
    }
    
    .card-body {
      padding: 2rem;
    }
    
    .card-footer {
      background-color: white;
      border-top: 1px solid rgba(0, 0, 0, 0.05);
      padding: 1.25rem 2rem;
    }
    
    /* Summary Cards */
    .summary-card {
      position: relative;
      overflow: hidden;
      border-left: 5px solid;
      background: linear-gradient(to bottom, white, #f8fafc);
    }
    
    .summary-card::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 100%;
      height: 200%;
      background: linear-gradient(45deg, transparent, rgba(255,255,255,0.4), transparent);
      transform: rotate(45deg);
      transition: var(--transition);
      opacity: 0;
    }
    
    .summary-card:hover::before {
      opacity: 1;
      animation: shine 1.2s;
    }
    
    @keyframes shine {
      0% { transform: rotate(45deg) translate(-30%, -30%); }
      100% { transform: rotate(45deg) translate(30%, 30%); }
    }
    
    .card-income {
      border-left-color: var(--secondary);
    }
    
    .card-expense {
      border-left-color: var(--danger);
    }
    
    .card-balance {
      border-left-color: var(--primary);
    }
    
    .summary-icon {
      width: 56px;
      height: 56px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.8rem;
      transition: var(--transition);
    }
    
    .summary-icon.income {
      background-color: rgba(244, 114, 182, 0.1);
      color: var(--secondary-dark);
    }
    
    .summary-icon.expense {
      background-color: rgba(239, 68, 68, 0.1);
      color: var(--danger-dark);
    }
    
    .summary-icon.balance {
      background-color: rgba(45, 212, 191, 0.1);
      color: var(--primary-dark);
    }
    
    .summary-card:hover .summary-icon {
      transform: scale(1.1);
    }
    
    /* Category Badges */
    .category-badge {
      display: inline-flex;
      align-items: center;
      padding: 0.4rem 1rem;
      border-radius: 999px;
      font-size: 0.85rem;
      font-weight: 500;
      line-height: 1;
      transition: var(--transition);
    }
    
    .category-badge:hover {
      transform: translateY(-1px);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .category-badge i {
      margin-right: 0.3rem;
      font-size: 0.9em;
    }
    
    .badge-income {
      background-color: rgba(244, 114, 182, 0.1);
      color: var(--secondary-dark);
    }
    
    .badge-food {
      background-color: rgba(245, 158, 11, 0.1);
      color: var(--warning-dark);
    }
    
    .badge-transport {
      background-color: rgba(59, 130, 246, 0.1);
      color: var(--info-dark);
    }
    
    .badge-shopping {
      background-color: rgba(236, 72, 153, 0.1);
      color: #9d174d;
    }
    
    .badge-bills {
      background-color: rgba(156, 163, 175, 0.1);
      color: var(--dark-light);
    }
    
    .badge-other {
      background-color: rgba(139, 92, 246, 0.1);
      color: #5b21b6;
    }
    
    /* Buttons */
    .btn {
      font-weight: 500;
      border-radius: var(--border-radius-sm);
      padding: 0.6rem 1.5rem;
      transition: var(--transition);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
    
    .btn-sm {
      padding: 0.4rem 1rem;
      font-size: 0.9rem;
    }
    
    .btn i {
      margin-right: 0.4rem;
    }
    
    .filter-btn {
      border-radius: 999px;
      margin: 0 0.3rem;
      font-size: 0.85rem;
      font-weight: 500;
      padding: 0.4rem 1.2rem;
    }
    
    .filter-btn.active {
      background-color: var(--primary);
      color: white;
      box-shadow: 0 3px 6px rgba(45, 212, 191, 0.3);
    }
    
    /* Forms */
    .form-control, .form-select {
      border-radius: var(--border-radius-sm);
      padding: 0.6rem 1rem;
      border: 1px solid #e5e7eb;
      transition: var(--transition);
      font-size: 0.95rem;
    }
    
    .form-control:focus, .form-select:focus {
      border-color: var(--primary-light);
      box-shadow: 0 0 0 4px rgba(45, 212, 191, 0.15);
      outline: none;
    }
    
    .input-group-text {
      background-color: #f8fafc;
      border-color: #e5e7eb;
      color: var(--gray);
    }
    
    .form-label {
      font-weight: 500;
      color: var(--dark-light);
      margin-bottom: 0.5rem;
    }
    
    /* Tables */
    .table {
      margin-bottom: 0;
      border-collapse: separate;
      border-spacing: 0;
    }
    
    .table th {
      background-color: var(--primary-dark);
      color: white;
      font-weight: 500;
      padding: 1rem 1.5rem;
      text-transform: uppercase;
      font-size: 0.8rem;
      letter-spacing: 0.5px;
      border-bottom: none;
    }
    
    .table td {
      padding: 1.25rem 1.5rem;
      vertical-align: middle;
      border-top: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .table tr:last-child td {
      border-bottom: none;
    }
    
    .table tr:hover {
      background-color: rgba(45, 212, 191, 0.05);
    }
    
    /* Amount styling */
    .amount-income {
      color: var(--secondary);
      font-weight: 600;
    }
    
    .amount-expense {
      color: var(--danger);
      font-weight: 600;
    }
    
    /* Loading spinner */
    .loading-spinner {
      display: inline-block;
      width: 1.2rem;
      height: 1.2rem;
      border: 3px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: white;
      animation: spin 0.8s ease-in-out infinite;
      margin-right: 0.5rem;
      vertical-align: middle;
    }
    
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
    
    /* Tabs */
    .nav-tabs {
      border-bottom: 1px solid rgba(0, 0, 0, 0.1);
      margin-bottom: 1.5rem;
    }
    
    .nav-tabs .nav-link {
      border: none;
      color: var(--gray);
      font-weight: 500;
      padding: 0.75rem 1.5rem;
      transition: var(--transition);
      border-radius: var(--border-radius-sm);
    }
    
    .nav-tabs .nav-link:hover {
      color: var(--primary-dark);
      background-color: rgba(45, 212, 191, 0.1);
    }
    
    .nav-tabs .nav-link.active {
      color: var(--primary-dark);
      font-weight: 600;
      border-bottom: 3px solid var(--primary);
      background-color: rgba(45, 212, 191, 0.15);
    }
    
    /* Charts */
    .chart-container {
      position: relative;
      height: 340px;
      min-height: 340px;
      background: white;
      border-radius: var(--border-radius);
      padding: 1rem;
      box-shadow: var(--shadow);
    }
    
    /* Empty state */
    .empty-state {
      text-align: center;
      padding: 4rem 0;
    }
    
    .empty-state i {
      font-size: 3.5rem;
      color: var(--gray-light);
      margin-bottom: 1.5rem;
    }
    
    .empty-state p {
      color: var(--gray);
      font-size: 1.2rem;
      margin-bottom: 1.5rem;
    }
    
    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .fade-in {
      animation: fadeIn 0.4s ease-out forwards;
    }
    
    /* Tooltips */
    .tooltip-inner {
      border-radius: var(--border-radius-sm);
      padding: 0.5rem 1rem;
      font-size: 0.9rem;
      background-color: var(--dark);
      color: white;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1200px) {
      .container {
        max-width: 100%;
        padding: 2rem 1.5rem;
      }
    }
    
    @media (max-width: 992px) {
      .chart-container {
        height: 300px;
      }
      
      .table th, .table td {
        padding: 1rem;
      }
    }
    
    @media (max-width: 768px) {
      .container {
        padding: 1.5rem 1rem;
      }
      
      .card-header {
        padding: 1.25rem;
      }
      
      .card-body {
        padding: 1.5rem;
      }
      
      .filter-btn {
        margin: 0.3rem;
        font-size: 0.8rem;
      }
      
      .summary-card {
        margin-bottom: 1.5rem;
      }
    }
    
    @media (max-width: 576px) {
      .chart-container {
        height: 260px;
      }
      
      .table-responsive {
        border-radius: var(--border-radius-sm);
        border: 1px solid rgba(0, 0, 0, 0.05);
      }
      
      .card-header {
        font-size: 1rem;
      }
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 10px;
      height: 10px;
    }
    
    ::-webkit-scrollbar-track {
      background: #f1f5f9;
      border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
      background: var(--primary-light);
      border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
      background: var(--primary);
    }
  </style>
</head>
<body>
<div class="container">
  <header class="mb-5 text-center">
    <h1 class="display-4 fw-bold mb-3" style="color: var(--primary-dark)">
      <i class="bi bi-piggy-bank me-2"></i> Expense Tracker Pro
    </h1>
    <p class="lead text-muted">Manage your finances with ease and insight</p>
  </header>

  <!-- Summary Cards -->
  <div class="row g-4 mb-5">
    <div class="col-md-4">
      <div class="card summary-card card-income h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-muted mb-2">Total Income</h6>
              <h3 class="mb-1" id="totalIncome">₹0</h3>
            </div>
            <div class="summary-icon income">
              <i class="bi bi-arrow-down-circle"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-md-4">
      <div class="card summary-card card-expense h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-muted mb-2">Total Expenses</h6>
              <h3 class="mb-1" id="totalExpense">₹0</h3>
            </div>
            <div class="summary-icon expense">
              <i class="bi bi-arrow-up-circle"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-md-4">
      <div class="card summary-card card-balance h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-muted mb-2">Current Balance</h6>
              <h3 class="mb-1" id="balance">₹0</h3>
            </div>
            <div class="summary-icon balance">
              <i class="bi bi-wallet2"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Transaction Forms -->
  <div class="row g-4 mb-5">
    <div class="col-lg-6">
      <div class="card h-100">
        <div class="card-header">
          <i class="bi bi-plus-circle"></i>
          <span>Add Income</span>
        </div>
        <div class="card-body">
          <form id="incomeForm">
            <div class="mb-4">
              <label class="form-label">Source</label>
              <input type="text" name="title" class="form-control" placeholder="Salary, Freelance, etc." required>
            </div>
            <div class="mb-4">
              <label class="form-label">Amount</label>
              <div class="input-group">
                <span class="input-group-text">₹</span>
                <input type="number" name="amount" step="0.01" min="0" class="form-control" placeholder="0.00" required>
              </div>
            </div>
            <div class="mb-4">
              <label class="form-label">Category</label>
              <select name="category" class="form-select" required>
                <option value="Salary">💼 Salary</option>
                <option value="Freelance">✍️ Freelance</option>
                <option value="Investment">📈 Investment</option>
                <option value="Gift">🎁 Gift</option>
                <option value="Other">❓ Other</option>
              </select>
            </div>
            <div class="mb-4">
              <label class="form-label">Date</label>
              <input type="date" name="date" class="form-control" value="<?=date('Y-m-d')?>">
            </div>
            <div class="mb-4">
              <label class="form-label">Description (Optional)</label>
              <textarea name="description" class="form-control" rows="3" placeholder="Additional details..."></textarea>
            </div>
            <button type="submit" class="btn btn-success w-100">
              <i class="bi bi-check-circle"></i> Add Income
            </button>
          </form>
        </div>
      </div>
    </div>
    
    <div class="col-lg-6">
      <div class="card h-100">
        <div class="card-header">
          <i class="bi bi-dash-circle"></i>
          <span>Add Expense</span>
        </div>
        <div class="card-body">
          <form id="expenseForm">
            <div class="mb-4">
              <label class="form-label">Title</label>
              <input type="text" name="title" class="form-control" placeholder="Groceries, Uber, etc." required>
            </div>
            <div class="mb-4">
              <label class="form-label">Amount</label>
              <div class="input-group">
                <span class="input-group-text">₹</span>
                <input type="number" name="amount" step="0.01" min="0" class="form-control" placeholder="0.00" required>
              </div>
            </div>
            <div class="mb-4">
              <label class="form-label">Category</label>
              <select name="category" class="form-select" required>
                <option value="Food">🍔 Food & Dining</option>
                <option value="Transport">🚗 Transport</option>
                <option value="Shopping">🛍️ Shopping</option>
                <option value="Bills">💡 Bills & Utilities</option>
                <option value="Entertainment">🎬 Entertainment</option>
                <option value="Healthcare">🏥 Healthcare</option>
                <option value="Other">❓ Other</option>
              </select>
            </div>
            <div class="mb-4">
              <label class="form-label">Date</label>
              <input type="date" name="date" class="form-control" value="<?=date('Y-m-d')?>">
            </div>
            <div class="mb-4">
              <label class="form-label">Description (Optional)</label>
              <textarea name="description" class="form-control" rows="3" placeholder="Additional details..."></textarea>
            </div>
            <button type="submit" class="btn btn-danger w-100">
              <i class="bi bi-x-circle"></i> Add Expense
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Visualizations -->
  <div class="card mb-5">
    <div class="card-header">
      <i class="bi bi-bar-chart-line"></i>
      <span>Financial Analytics</span>
    </div>
    <div class="card-body">
      <ul class="nav nav-tabs mb-4" id="chartTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">Overview</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="trends-tab" data-bs-toggle="tab" data-bs-target="#trends" type="button" role="tab">Trends</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button" role="tab">Categories</button>
        </li>
      </ul>
      <div class="tab-content" id="chartTabsContent">
        <div class="tab-pane fade show active" id="overview" role="tabpanel">
          <div class="row g-4">
            <div class="col-lg-6">
              <div class="chart-container">
                <canvas id="pieChart"></canvas>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="chart-container">
                <canvas id="barChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="trends" role="tabpanel">
          <div class="chart-container" style="height: 400px">
            <canvas id="trendChart"></canvas>
          </div>
        </div>
        <div class="tab-pane fade" id="categories" role="tabpanel">
          <div class="chart-container" style="height: 400px">
            <canvas id="categoryTrendChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Transaction History -->
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
      <div class="d-flex align-items-center mb-2 mb-md-0">
        <i class="bi bi-clock-history me-2"></i>
        <span>Transaction History</span>
      </div>
      <div class="btn-group btn-group-sm flex-wrap">
        <button class="btn btn-outline-primary filter-btn active" data-filter="all">All</button>
        <button class="btn btn-outline-primary filter-btn" data-filter="daily">Today</button>
        <button class="btn btn-outline-primary filter-btn" data-filter="weekly">Week</button>
        <button class="btn btn-outline-primary filter-btn" data-filter="monthly">Month</button>
        <button class="btn btn-outline-primary filter-btn" data-filter="income">Income</button>
        <button class="btn btn-outline-primary filter-btn" data-filter="expense">Expenses</button>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th>Description</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Category</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="transactionsTable">
          <tr>
            <td colspan="6" class="text-center py-5 text-muted">
              <div class="empty-state">
                <i class="bi bi-credit-card-2-back"></i>
                <p>No transactions found</p>
                <button class="btn btn-primary mt-2" onclick="document.getElementById('incomeForm').scrollIntoView({behavior: 'smooth'})">
                  <i class="bi bi-plus-circle"></i> Add Your First Transaction
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
      <div class="text-muted small">
        Showing <span id="showingCount">0</span> of <span id="totalCount">0</span> transactions
      </div>
      <div>
        <button class="btn btn-sm btn-outline-primary" id="prevPage" disabled>
          <i class="bi bi-chevron-left"></i> Previous
        </button>
        <button class="btn btn-sm btn-outline-primary ms-2" id="nextPage" disabled>
          Next <i class="bi bi-chevron-right"></i>
        </button>
      </div>
    </div>
  </div>
</div>

<script>
// Global variables
let pieChart, barChart, trendChart, categoryTrendChart;
let currentPage = 1;
const transactionsPerPage = 10;
let allTransactions = [];

// Initialize charts with updated theme colors
function initCharts() {
  // Pie Chart (Doughnut)
  const pieCtx = document.getElementById('pieChart').getContext('2d');
  pieChart = new Chart(pieCtx, {
    type: 'doughnut',
    data: {
      labels: ['Income', 'Expenses'],
      datasets: [{
        data: [0, 0],
        backgroundColor: [
          'rgba(244, 114, 182, 0.8)', // Coral
          'rgba(239, 68, 68, 0.8)'   // Danger
        ],
        borderColor: [
          'rgba(244, 114, 182, 1)',
          'rgba(239, 68, 68, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'right',
          labels: {
            boxWidth: 14,
            padding: 20,
            usePointStyle: true,
            font: {
              family: 'Inter',
              size: 13
            }
          }
        },
        tooltip: {
          backgroundColor: 'rgba(17, 24, 39, 0.95)',
          titleFont: {
            family: 'Inter',
            size: 14,
            weight: '600'
          },
          bodyFont: {
            family: 'Inter',
            size: 13
          },
          callbacks: {
            label: function(context) {
              const label = context.label || '';
              const value = context.raw || 0;
              const total = context.dataset.data.reduce((a, b) => a + b, 0);
              const percentage = Math.round((value / total) * 100);
              return `${label}: ₹${value.toLocaleString('en-IN')} (${percentage}%)`;
            }
          }
        },
        datalabels: {
          formatter: (value, ctx) => {
            const sum = ctx.dataset.data.reduce((a, b) => a + b, 0);
            const percentage = (value * 100 / sum).toFixed(1);
            return percentage > 5 ? percentage + '%' : '';
          },
          color: '#fff',
          font: {
            weight: 'bold',
            family: 'Inter',
            size: 12
          }
        }
      },
      cutout: '70%',
      animation: {
        animateScale: true,
        animateRotate: true,
        duration: 1200
      }
    },
    plugins: [ChartDataLabels]
  });

  // Bar Chart
  const barCtx = document.getElementById('barChart').getContext('2d');
  barChart = new Chart(barCtx, {
    type: 'bar',
    data: {
      labels: ['Income', 'Expenses', 'Balance'],
      datasets: [{
        label: 'Amount',
        data: [0, 0, 0],
        backgroundColor: [
          'rgba(244, 114, 182, 0.8)',
          'rgba(239, 68, 68, 0.8)',
          'rgba(45, 212, 191, 0.8)'
        ],
        borderColor: [
          'rgba(244, 114, 182, 1)',
          'rgba(239, 68, 68, 1)',
          'rgba(45, 212, 191, 1)'
        ],
        borderWidth: 1,
        borderRadius: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: value => '₹' + Number(value).toLocaleString('en-IN'),
            font: {
              family: 'Inter',
              size: 12
            }
          },
          grid: {
            color: 'rgba(0, 0, 0, 0.05)'
          }
        },
        x: {
          grid: {
            display: false
          },
          ticks: {
            font: {
              family: 'Inter',
              size: 12
            }
          }
        }
      },
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          backgroundColor: 'rgba(17, 24, 39, 0.95)',
          titleFont: {
            family: 'Inter',
            size: 14,
            weight: '600'
          },
          bodyFont: {
            family: 'Inter',
            size: 13
          },
          callbacks: {
            label: function(context) {
              const label = context.dataset.label || '';
              const value = context.raw || 0;
              return `${label}: ₹${value.toLocaleString('en-IN')}`;
            }
          }
        }
      },
      animation: {
        duration: 1200,
        easing: 'easeOutCubic'
      }
    }
  });

  // Trend Chart (Line)
  const trendCtx = document.getElementById('trendChart').getContext('2d');
  trendChart = new Chart(trendCtx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
      datasets: [
        {
          label: 'Income',
          data: [0, 0, 0, 0, 0, 0, 0],
          backgroundColor: 'rgba(244, 114, 182, 0.1)',
          borderColor: 'rgba(244, 114, 182, 1)',
          borderWidth: 2,
          tension: 0.4,
          fill: true,
          pointBackgroundColor: 'rgba(244, 114, 182, 1)',
          pointRadius: 4,
          pointHoverRadius: 8
        },
        {
          label: 'Expenses',
          data: [0, 0, 0, 0, 0, 0, 0],
          backgroundColor: 'rgba(239, 68, 68, 0.1)',
          borderColor: 'rgba(239, 68, 68, 1)',
          borderWidth: 2,
          tension: 0.4,
          fill: true,
          pointBackgroundColor: 'rgba(239, 68, 68, 1)',
          pointRadius: 4,
          pointHoverRadius: 8
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: value => '₹' + Number(value).toLocaleString('en-IN'),
            font: {
              family: 'Inter',
              size: 12
            }
          },
          grid: {
            color: 'rgba(0, 0, 0, 0.05)'
          }
        },
        x: {
          grid: {
            display: false
          },
          ticks: {
            font: {
              family: 'Inter',
              size: 12
            }
          }
        }
      },
      plugins: {
        legend: {
          position: 'top',
          labels: {
            font: {
              family: 'Inter',
              size: 12
            },
            usePointStyle: true
          }
        },
        tooltip: {
          backgroundColor: 'rgba(17, 24, 39, 0.95)',
          titleFont: {
            family: 'Inter',
            size: 14,
            weight: '600'
          },
          bodyFont: {
            family: 'Inter',
            size: 13
          },
          callbacks: {
            label: function(context) {
              const label = context.dataset.label || '';
              const value = context.raw || 0;
              return `${label}: ₹${value.toLocaleString('en-IN')}`;
            }
          }
        }
      },
      interaction: {
        mode: 'index',
        intersect: false
      },
      animation: {
        duration: 1200,
        easing: 'easeOutCubic'
      }
    }
  });

  // Category Trend Chart (Bar)
  const categoryTrendCtx = document.getElementById('categoryTrendChart').getContext('2d');
  categoryTrendChart = new Chart(categoryTrendCtx, {
    type: 'bar',
    data: {
      labels: ['Food', 'Transport', 'Shopping', 'Bills', 'Other'],
      datasets: [{
        label: 'Expenses by Category',
        data: [0, 0, 0, 0, 0],
        backgroundColor: [
          'rgba(245, 158, 11, 0.8)',
          'rgba(59, 130, 246, 0.8)',
          'rgba(236, 72, 153, 0.8)',
          'rgba(156, 163, 175, 0.8)',
          'rgba(139, 92, 246, 0.8)'
        ],
        borderColor: [
          'rgba(245, 158, 11, 1)',
          'rgba(59, 130, 246, 1)',
          'rgba(236, 72, 153, 1)',
          'rgba(156, 163, 175, 1)',
          'rgba(139, 92, 246, 1)'
        ],
        borderWidth: 1,
        borderRadius: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: value => '₹' + Number(value).toLocaleString('en-IN'),
            font: {
              family: 'Inter',
              size: 12
            }
          },
          grid: {
            color: 'rgba(0, 0, 0, 0.05)'
          }
        },
        x: {
          grid: {
            display: false
          },
          ticks: {
            font: {
              family: 'Inter',
              size: 12
            }
          }
        }
      },
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          backgroundColor: 'rgba(17, 24, 39, 0.95)',
          titleFont: {
            family: 'Inter',
            size: 14,
            weight: '600'
          },
          bodyFont: {
            family: 'Inter',
            size: 13
          },
          callbacks: {
            label: function(context) {
              const label = context.dataset.label || '';
              const value = context.raw || 0;
              return `${label}: ₹${value.toLocaleString('en-IN')}`;
            }
          }
        }
      },
      animation: {
        duration: 1200,
        easing: 'easeOutCubic'
      }
    }
  });
}

// Fetch data with loading state
async function fetchAll(filter = 'all') {
  const tbody = document.getElementById('transactionsTable');
  tbody.innerHTML = `
    <tr>
      <td colspan="6" class="text-center py-5">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3 text-muted">Loading transactions...</p>
      </td>
    </tr>
  `;

  try {
    const res = await fetch('fetch_data.php?filter=' + encodeURIComponent(filter));
    const data = await res.json();
    
    if (!data.ok) {
      throw new Error(data.error || 'Failed to fetch data');
    }

    allTransactions = data.transactions || [];
    updateSummary(data);
    updateTable(allTransactions);
    updateCharts(data);
    updatePagination(allTransactions.length);
  } catch (e) {
    console.error('Fetch error:', e);
    tbody.innerHTML = `
      <tr>
        <td colspan="6" class="text-center py-5 text-danger">
          <i class="bi bi-exclamation-triangle fs-1"></i>
          <p class="mt-3">Failed to load data. Please try again.</p>
        </td>
      </tr>
    `;
  }
}

// Update summary cards
function updateSummary(data) {
  animateValue('totalIncome', 0, data.totalIncome, 1000);
  animateValue('totalExpense', 0, data.totalExpense, 1000);
  animateValue('balance', 0, data.balance, 1000);
  
  const balanceElement = document.getElementById('balance');
  balanceElement.style.color = data.balance < 0 ? 'var(--danger)' : 'var(--primary)';
}

// Animate number counting
function animateValue(id, start, end, duration) {
  const obj = document.getElementById(id);
  let startTimestamp = null;
  const step = (timestamp) => {
    if (!startTimestamp) startTimestamp = timestamp;
    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
    const value = Math.floor(progress * (end - start) + start);
    obj.textContent = '₹' + value.toLocaleString('en-IN');
    if (progress < 1) {
      window.requestAnimationFrame(step);
    }
  };
  window.requestAnimationFrame(step);
}

// Update transaction table with pagination
function updateTable(transactions) {
  const tbody = document.getElementById('transactionsTable');
  
  if (transactions.length === 0) {
    tbody.innerHTML = `
      <tr>
        <td colspan="6" class="text-center py-5 text-muted">
          <div class="empty-state">
            <i class="bi bi-credit-card-2-back fs-1"></i>
            <p class="mt-3">No transactions found</p>
            <button class="btn btn-primary mt-2" onclick="document.getElementById('incomeForm').scrollIntoView({behavior: 'smooth'})">
              <i class="bi bi-plus-circle"></i> Add Your First Transaction
            </button>
          </div>
        </td>
      </tr>
    `;
    return;
  }

  const start = (currentPage - 1) * transactionsPerPage;
  const end = start + transactionsPerPage;
  const paginated = transactions.slice(start, end);

  tbody.innerHTML = paginated.map(t => {
    const amount = (t.type === 'income' ? '+' : '-') + '₹' + Number(t.amount).toLocaleString('en-IN');
    const typeClass = t.type === 'income' ? 'amount-income' : 'amount-expense';
    const typeIcon = t.type === 'income' ? 
      '<i class="bi bi-arrow-down-circle text-success"></i>' : 
      '<i class="bi bi-arrow-up-circle text-danger"></i>';
    
    const date = new Date(t.date).toLocaleDateString('en-IN', {
      day: '2-digit',
      month: 'short',
      year: 'numeric'
    });
    
    // Determine badge class based on category
    let badgeClass = 'badge-other';
    let badgeIcon = '❓';
    if (t.type === 'income') {
      badgeClass = 'badge-income';
      badgeIcon = t.category === 'Salary' ? '💼' : 
                 t.category === 'Freelance' ? '✍️' : 
                 t.category === 'Investment' ? '📈' : 
                 t.category === 'Gift' ? '🎁' : '❓';
    } else if (t.category === 'Food') {
      badgeClass = 'badge-food';
      badgeIcon = '🍔';
    } else if (t.category === 'Transport') {
      badgeClass = 'badge-transport';
      badgeIcon = '🚗';
    } else if (t.category === 'Shopping') {
      badgeClass = 'badge-shopping';
      badgeIcon = '🛍️';
    } else if (t.category === 'Bills') {
      badgeClass = 'badge-bills';
      badgeIcon = '💡';
    } else if (t.category === 'Entertainment') {
      badgeClass = 'badge-other';
      badgeIcon = '🎬';
    } else if (t.category === 'Healthcare') {
      badgeClass = 'badge-other';
      badgeIcon = '🏥';
    }
    
    return `
      <tr class="fade-in">
        <td>${t.description || '<span class="text-muted">No description</span>'}</td>
        <td>${typeIcon} ${t.type.charAt(0).toUpperCase() + t.type.slice(1)}</td>
        <td class="${typeClass}">${amount}</td>
        <td><span class="category-badge ${badgeClass}"><i>${badgeIcon}</i> ${t.category}</span></td>
        <td>${date}</td>
        <td>
          <button class="btn btn-sm btn-outline-danger" onclick="deleteTx(${t.id},'${t.type}')" data-bs-toggle="tooltip" title="Delete transaction">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      </tr>
    `;
  }).join('');

  document.getElementById('showingCount').textContent = Math.min(end, transactions.length);
}

// Update pagination controls
function updatePagination(total) {
  document.getElementById('totalCount').textContent = total;
  document.getElementById('prevPage').disabled = currentPage === 1;
  document.getElementById('nextPage').disabled = (currentPage * transactionsPerPage) >= total;
}

// Update charts with new data
function updateCharts(data) {
  // Update pie chart (Income vs Expenses)
  pieChart.data.datasets[0].data = [data.totalIncome || 0, data.totalExpense || 0];
  pieChart.update();

  // Update bar chart (Income, Expenses, Balance)
  barChart.data.datasets[0].data = [data.totalIncome || 0, data.totalExpense || 0, data.balance || 0];
  barChart.update();

  // Update trend chart
  trendChart.data.labels = data.trendLabels && data.trendLabels.length > 0 ? data.trendLabels : ['No Data'];
  trendChart.data.datasets[0].data = data.trendIncome && data.trendIncome.length > 0 ? data.trendIncome : [0];
  trendChart.data.datasets[1].data = data.trendExpense && data.trendExpense.length > 0 ? data.trendExpense : [0];
  trendChart.update();

  // Update category trend chart
  categoryTrendChart.data.labels = data.categories && data.categories.length > 0 ? data.categories : ['No Data'];
  categoryTrendChart.data.datasets[0].data = data.categoryTotals && data.categoryTotals.length > 0 ? data.categoryTotals : [0];
  categoryTrendChart.update();
}

// Delete transaction with confirmation
async function deleteTx(id, type) {
  if (!confirm('Are you sure you want to delete this transaction?\nThis action cannot be undone.')) {
    return;
  }

  const btn = event.target.closest('button');
  const originalHtml = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<span class="loading-spinner"></span> Deleting...';

  try {
    const res = await fetch('delete_transaction.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id=${encodeURIComponent(id)}&type=${encodeURIComponent(type)}`
    });
    
    const result = await res.json();
    
    if (result.ok) {
      btn.innerHTML = '<i class="bi bi-check-circle"></i> Deleted';
      btn.classList.remove('btn-outline-danger');
      btn.classList.add('btn-outline-success');
      
      setTimeout(() => {
        const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;
        fetchAll(activeFilter);
      }, 1000);
    } else {
      throw new Error(result.error || 'Delete failed');
    }
  } catch (error) {
    console.error('Delete error:', error);
    btn.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Error';
    btn.classList.remove('btn-outline-danger');
    btn.classList.add('btn-outline-warning');
    
    setTimeout(() => {
      btn.innerHTML = originalHtml;
      btn.disabled = false;
      btn.classList.remove('btn-outline-warning');
      btn.classList.add('btn-outline-danger');
    }, 2000);
  }
}

// Form submission handlers with loading states
document.getElementById('incomeForm').addEventListener('submit', async e => {
  e.preventDefault();
  const form = e.target;
  const btn = form.querySelector('button[type="submit"]');
  const originalHtml = btn.innerHTML;
  
  btn.disabled = true;
  btn.innerHTML = '<span class="loading-spinner"></span> Processing...';

  try {
    const formData = new FormData(form);
    const body = new URLSearchParams(formData);
    
    const res = await fetch('add_income.php', {
      method: 'POST',
      body
    });
    
    const result = await res.json();
    
    if (result.ok) {
      btn.innerHTML = '<i class="bi bi-check-circle"></i> Success!';
      btn.classList.remove('btn-success');
      btn.classList.add('btn-outline-success');
      
      form.reset();
      
      setTimeout(() => {
        const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;
        fetchAll(activeFilter);
        
        setTimeout(() => {
          btn.innerHTML = originalHtml;
          btn.disabled = false;
          btn.classList.remove('btn-outline-success');
          btn.classList.add('btn-success');
        }, 1000);
      }, 500);
    } else {
      throw new Error(result.error || 'Add failed');
    }
  } catch (error) {
    console.error('Add income error:', error);
    btn.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Error';
    btn.classList.remove('btn-success');
    btn.classList.add('btn-outline-danger');
    
    setTimeout(() => {
      btn.innerHTML = originalHtml;
      btn.disabled = false;
      btn.classList.remove('btn-outline-danger');
      btn.classList.add('btn-success');
    }, 2000);
  }
});

document.getElementById('expenseForm').addEventListener('submit', async e => {
  e.preventDefault();
  const form = e.target;
  const btn = form.querySelector('button[type="submit"]');
  const originalHtml = btn.innerHTML;
  
  btn.disabled = true;
  btn.innerHTML = '<span class="loading-spinner"></span> Processing...';

  try {
    const formData = new FormData(form);
    const body = new URLSearchParams(formData);
    
    const res = await fetch('add_expense.php', {
      method: 'POST',
      body
    });
    
    const result = await res.json();
    
    if (result.ok) {
      btn.innerHTML = '<i class="bi bi-check-circle"></i> Success!';
      btn.classList.remove('btn-danger');
      btn.classList.add('btn-outline-success');
      
      form.reset();
      
      setTimeout(() => {
        const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;
        fetchAll(activeFilter);
        
        setTimeout(() => {
          btn.innerHTML = originalHtml;
          btn.disabled = false;
          btn.classList.remove('btn-outline-success');
          btn.classList.add('btn-danger');
        }, 1000);
      }, 500);
    } else {
      throw new Error(result.error || 'Add failed');
    }
  } catch (error) {
    console.error('Add expense error:', error);
    btn.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Error';
    btn.classList.remove('btn-danger');
    btn.classList.add('btn-outline-danger');
    
    setTimeout(() => {
      btn.innerHTML = originalHtml;
      btn.disabled = false;
      btn.classList.remove('btn-outline-danger');
      btn.classList.add('btn-danger');
    }, 2000);
  }
});

// Filter button handlers
document.querySelectorAll('.filter-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    currentPage = 1;
    fetchAll(btn.dataset.filter);
  });
});

// Pagination handlers
document.getElementById('prevPage').addEventListener('click', () => {
  if (currentPage > 1) {
    currentPage--;
    updateTable(allTransactions);
    updatePagination(allTransactions.length);
  }
});

document.getElementById('nextPage').addEventListener('click', () => {
  if (currentPage * transactionsPerPage < allTransactions.length) {
    currentPage++;
    updateTable(allTransactions);
    updatePagination(allTransactions.length);
  }
});

// Initialize the application
document.addEventListener('DOMContentLoaded', () => {
  initCharts();
  fetchAll();
  
  // Initialize Bootstrap tooltips
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  tooltipTriggerList.forEach(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
});

// Format all currency inputs on page
document.querySelectorAll('input[type="number"]').forEach(input => {
  input.addEventListener('blur', () => {
    if (input.value && !isNaN(input.value)) {
      input.value = parseFloat(input.value).toFixed(2);
    }
  });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
