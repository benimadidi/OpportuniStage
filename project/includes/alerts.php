
<!--//////////////////////////////////////////////////////////////////////////////////////////-->
            <!-- Gestion des alertes -->
<?php if(!empty($alerts)) : ?>

    <div class="alert-box">

        <?php foreach($alerts as $alert) : ?>
            
            <div class="alert <?php echo $alert['type'] ?>">
                <i class="bx <?php echo $alert['type'] === 'success' ? 'bxs-check-circle' : 'bxs-x-circle'; ?>"></i>
                <p><?php echo $alert['message'] ?></p>
            </div>

        <?php endforeach; ?>

    </div>

<?php endif; ?>