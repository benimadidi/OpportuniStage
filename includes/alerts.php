
    <!--////////////////////////////////////////////////////-->
    <!-- Gestion des alertes -->
    <?php if(!empty($alerts)) : ?>

        <div class="alert-box">

            <?php foreach($alerts as $alert) : ?>
                
                <div class="alert <?= $alert['type'] ?>">
                    <i class="bx <?= $alert['message'] === 'success' ? 'bxs-check-circle' : 'bxs-x-circle'; ?>"></i>
                    <p><?= $alert['message'] ?></p>
                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>