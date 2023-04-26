SELECT
    row_number() over () AS `row_number`,
    `client_id`,
    `price_sum`,
    `first_order_date`,
    `last_order_date`
FROM (
    SELECT
        `id`,
        `client_id`,
        sum(`price`) over (PARTITION BY `client_id`) AS `price_sum`,
        min(`DATE`) over (PARTITION BY `client_id`) AS `first_order_date`,
        max(`DATE`) over (PARTITION BY `client_id`) AS `last_order_date`,
        row_number() over ()
    FROM `orders`
    WHERE `DATE` >= '2023-04-01'
    ORDER BY `price_sum` DESC
) AS `t1`
GROUP BY `client_id`
LIMIT 3;
