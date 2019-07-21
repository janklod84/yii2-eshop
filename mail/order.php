<!-- Вид для Е-майл -->
<div class="table-responsive">
<table class="table table-hover table-striped" style="width: 100%; border: 1px solid #ddd; border-collapse: collapse;">
    <thead>
    <tr style="background: #f9f9f9;">
        <th style="padding: 8px; border: 1px solid #ddd;">Наименование</th>
        <th style="padding: 8px; border: 1px solid #ddd;">Кол-во</th>
        <th style="padding: 8px; border: 1px solid #ddd;">Цена</th>
        <th style="padding: 8px; border: 1px solid #ddd;">Сумма</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($session['cart'] as $id => $item): ?>
        <tr>
            <?php
             #  Do Link : http://yii.loc/product/view
             #  \yii\helpers\Url::to(['product/view', 'id' => $id], true)
            ?>
            <td><?= $item['name'] ?></td>
            <td><?= $item['qty'] ?></td>
            <td><?= $item['price'] ?></td>
            <td><?= $item['qty'] * $item['price'] ?></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="3">Итого: </td>
        <td><?= $session['cart.qty'] ?></td>
    </tr>
    <tr>
        <td colspan="3">На сумму: </td>
        <td><?= $session['cart.sum'] ?></td>
    </tr>
    </tbody>
 </table>
</div>