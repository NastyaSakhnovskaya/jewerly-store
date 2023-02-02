<?php
include "header.php";
echo "<link rel='stylesheet' href='css/basket.css'>";
?>
<section class="person">
    <div class="container">
        <div class="wrapper">
            <div class="person__screen">
                <div class="person__info">
                    <a class="basket__text" href="acc/basketInfo.php" target="CONTENT">Корзина</a>
                    <a class="basket__text" href="acc/personalData.php" target="CONTENT">Заказы</a>
                </div>
                <div class="person__result">
                <iframe id="iframe" alloytransparency name="CONTENT" align="middle" width="100%"  scrolling="no" display:block style="border: 0; height: 70vh" src="acc/basketInfo.php">Ваш браузер не поддерживает iframe</iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include "footer.php";
?>