<!-- lucky_numbers_template.php -->
<h2>Números da Sorte</h2>

<?php if (count($results) > 0): ?>
    <table>
        <tr>
            <th>Número da Sorte</th>
            <th>ID da Promoção</th>
            <th>ID do Pedido</th>
            <th>ID do Item do Pedido</th>
        </tr>
        <?php foreach($results as $row): ?>
            <tr>
                <td><?php echo $row['lucky_number']; ?></td>
                <td><?php echo $row['promotion_id']; ?></td>
                <td><?php echo $row['order_id']; ?></td>
                <td><?php echo $row['order_item_id']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Você ainda não tem números da sorte.</p>
<?php endif; ?>
