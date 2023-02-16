SELECT name, reference, price, weight, category_id, MAX(stock) FROM konecta_products;

SELECT p.name, SUM(s.amount) as 'Mas vendido' FROM konecta_products p 
                JOIN konecta_shoppings s ON s.product_id = p.id
                GROUP BY p.id
                ORDER BY SUM(s.amount) DESC;