<?
//#2
function sortDeliveryMethods($deliveryData) {
    $result = array();

    foreach ($deliveryData as $deliveryItem)
        foreach ($deliveryItem['customer_costs'] as $key => $customer_costs)
            $result[$key][$deliveryItem['code']] = $customer_costs;

    return $result;
}

$deliveryMethodsArray = [
    [
        'code' => 'dhl',
        'customer_costs' => [
            22 => '1.000',
            11 => '3.000',
        ]
    ],
    [
        'code' => 'fedex',
        'customer_costs' => [
            22 => '4.000',
            11 => '6.000',
        ]
    ]
];

$result = sortDeliveryMethods($deliveryMethodsArray);
echo "<pre>";
var_dump($result);
echo "</pre>";