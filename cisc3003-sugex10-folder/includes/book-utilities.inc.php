<?php
function readCustomers($filename) {
    $customers = [];
    if (!file_exists($filename)) return $customers;
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $data = explode(';', $line);
        if (count($data) >= 12) {
            $customers[] = [
                'id'         => trim($data[0]),
                'first_name' => trim($data[1]),
                'last_name'  => trim($data[2]),
                'email'      => trim($data[3]),
                'university' => trim($data[4]),
                'address'    => trim($data[5]),
                'city'       => trim($data[6]),
                'state'      => trim($data[7]),
                'country'    => trim($data[8]),
                'zip'        => trim($data[9]),
                'phone'      => trim($data[10]),
                'sales'      => trim($data[11])
            ];
        }
    }
    return $customers;
}

function readOrders($customerId, $filename) {
    $orders = [];
    if (!file_exists($filename)) return $orders;
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $data = explode(';', $line);
        if (count($data) >= 5 && trim($data[1]) == $customerId) {
            $orders[] = [
                'order_id'    => trim($data[0]),
                'customer_id' => trim($data[1]),
                'isbn'        => trim($data[2]),
                'title'       => trim($data[3]),
                'category'    => trim($data[4])
            ];
        }
    }
    return $orders;
}
?>