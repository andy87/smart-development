<?php

use models\dto\profile\FriendProfile;

/**
 * @var FriendProfile $friendProfile
 */

?>

<div class="block__friend">

    <div class="b_profile--layer __me">

        <a class="b_profile--link" href="<?= $friendProfile->urlToProfile() ?>">
            <h2 class="b_profile--nickname">
                <?= $friendProfile->nickname ?>
            </h2>
        </a>

        <div class="block__counters">
            <div class="b_counter--item">
                <span class="b_counter--label">followers</span>
                <span class="b_counter--value"><?= $friendProfile->followers ?></span>
            </div>
        </div>

    </div>

</div>