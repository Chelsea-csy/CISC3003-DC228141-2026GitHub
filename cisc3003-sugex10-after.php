<?php
include 'includes/book-utilities.inc.php';

// 读取所有客户数据
$customers = readCustomers('data/customers.txt');

// 获取当前选中的客户ID
$selectedCustomer = null;
if (isset($_GET['customer_id'])) {
    $cid = $_GET['customer_id'];
    foreach ($customers as $c) {
        if ($c['id'] == $cid) {
            $selectedCustomer = $c;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>CISC3003 - dc228141 陈思懿 - Suggested Exercise 10</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="css/material.min.css">
	<link rel="stylesheet" href="css/demo-styles.css">
	<link rel="stylesheet" href="css/styles.css">
    
    <script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="https://code.getmdl.io/1.1.3/material.min.js"></script>
    <script src="js/jquery.sparkline.2.1.2.js"></script>
</head>

<body>
    
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
            
    <?php include 'includes/header.inc.php'; ?>
    <?php include 'includes/left-nav.inc.php'; ?>
    
    <main class="mdl-layout__content mdl-color--grey-50">
        <section class="page-content">

            <div class="mdl-grid">

                <!-- 客户表格卡片 -->
                <div class="mdl-cell mdl-cell--7-col card-lesson mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-color--orange">
                        <h2 class="mdl-card__title-text">Customers</h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <table class="mdl-data-table mdl-shadow--2dp">
                            <thead>
                                <tr>
                                    <th class="mdl-data-table__cell--non-numeric">Name</th>
                                    <th class="mdl-data-table__cell--non-numeric">University</th>
                                    <th class="mdl-data-table__cell--non-numeric">City</th>
                                    <th>Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($customers as $cust): ?>
                                    <?php 
                                        $fullName = htmlspecialchars($cust['first_name'] . ' ' . $cust['last_name']);
                                        $nameLink = '<a href="?customer_id=' . urlencode($cust['id']) . '">' . $fullName . '</a>';
                                        $salesNumbers = explode(',', $cust['sales']);
                                        $salesNumbers = array_map('trim', $salesNumbers);
                                        $sparkHtml = '<span class="sparkline" data-values="' . implode(',', $salesNumbers) . '"></span>';
                                    ?>
                                    <tr>
                                        <td class="mdl-data-table__cell--non-numeric"><?php echo $nameLink; ?></td>
                                        <td class="mdl-data-table__cell--non-numeric"><?php echo htmlspecialchars($cust['university']); ?></td>
                                        <td class="mdl-data-table__cell--non-numeric"><?php echo htmlspecialchars($cust['city']); ?></td>
                                        <td><?php echo $sparkHtml; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>  <!-- 结束客户表格卡片 -->
              
                <div class="mdl-grid mdl-cell--5-col">
    
                    <!-- 客户详情卡片 -->
                    <div class="mdl-cell mdl-cell--12-col card-lesson mdl-card mdl-shadow--2dp">
                        <div class="mdl-card__title mdl-color--deep-purple mdl-color-text--white">
                            <h2 class="mdl-card__title-text">Customer Details</h2>
                        </div>
                        <div class="mdl-card__supporting-text">
                            <?php if ($selectedCustomer): ?>
                                <h4><?php echo htmlspecialchars($selectedCustomer['first_name'] . ' ' . $selectedCustomer['last_name']); ?></h4>
                                <p>
                                    <strong>Email:</strong> <?php echo htmlspecialchars($selectedCustomer['email']); ?><br>
                                    <strong>University:</strong> <?php echo htmlspecialchars($selectedCustomer['university']); ?><br>
                                    <strong>Address:</strong> <?php echo htmlspecialchars($selectedCustomer['address'] . ', ' . $selectedCustomer['city'] . ', ' . $selectedCustomer['state'] . ' ' . $selectedCustomer['zip']); ?><br>
                                    <strong>Phone:</strong> <?php echo htmlspecialchars($selectedCustomer['phone']); ?>
                                </p>
                            <?php else: ?>
                                <h4>No customer selected</h4>
                                <p>Click on a customer name to view details.</p>
                            <?php endif; ?>
                        </div>    
                    </div>  <!-- 结束客户详情卡片 -->

                    <!-- 订单详情卡片 -->
                    <div class="mdl-cell mdl-cell--12-col card-lesson mdl-card mdl-shadow--2dp">
                        <div class="mdl-card__title mdl-color--deep-purple mdl-color-text--white">
                            <h2 class="mdl-card__title-text">Order Details</h2>
                        </div>
                        <div class="mdl-card__supporting-text">       
                            <table class="mdl-data-table mdl-shadow--2dp">
                                <thead>
                                    <tr>
                                        <th class="mdl-data-table__cell--non-numeric">Cover</th>
                                        <th class="mdl-data-table__cell--non-numeric">ISBN</th>
                                        <th class="mdl-data-table__cell--non-numeric">Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($selectedCustomer): ?>
                                        <?php 
                                            $orders = readOrders($selectedCustomer['id'], 'data/orders.txt');
                                            if (count($orders) > 0):
                                                foreach ($orders as $order): 
                                        ?>
                                            <tr>
                                                <td class="mdl-data-table__cell--non-numeric"><i class="material-icons">book</i></td>
                                                <td class="mdl-data-table__cell--non-numeric"><?php echo htmlspecialchars($order['isbn']); ?></td>
                                                <td class="mdl-data-table__cell--non-numeric"><?php echo htmlspecialchars($order['title']); ?></td>
                                            </tr>
                                        <?php 
                                                endforeach;
                                            else:
                                        ?>
                                            <tr>
                                                <td colspan="3" class="mdl-data-table__cell--non-numeric">No order information for this customer.</td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="mdl-data-table__cell--non-numeric">Select a customer to see orders.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>    
                    </div>  <!-- 结束订单详情卡片 -->             

                </div>   <!-- 结束右侧网格 -->
           
            </div>  <!-- 结束主网格 -->    

        </section>
    </main>    
</div>    <!-- 结束布局 -->

<footer style="text-align: center; padding: 20px; background: #f5f5f5; margin-top: 20px;">
    CISC3003 Web Programming: dc228141 陈思懿 2026
</footer>

<script>
$(function() {
    $('.sparkline').each(function() {
        var values = $(this).data('values').split(',');
        $(this).sparkline(values, { type: 'bar' });
    });
});
</script>

</body>
</html>