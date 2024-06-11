<?php

use models\dto\profile\FriendProfile;
use resources\profile\ProfileMeResources;

/**
 * @var ProfileMeResources $R
 */

$userProfile = $R->userProfile;
$friendProfileList = $R->friendProfileList;

?>

<div class="block__profile">

    <div class="b_profile--layer __me">

        <h1 class="b_profile--nickname"><?= $userProfile->name ?></h1>

        <img class="b_profile--avatar" src="<?= $userProfile->avatar ?>" alt="<?= $userProfile->name ?>">

        <div class="block__counters">
            <div class="b_counter--item">
                <span class="b_counter--label">followers</span>
                <span class="b_counter--value"><?= $userProfile->followers ?></span>
            </div>
            <div class="b_counter--item">
                <span class="b_counter--label">subscribers</span>
                <span class="b_counter--value"><?= $userProfile->subscribers ?></span>
            </div>
            <div class="b_counter--item">
                <span class="b_counter--label">streams</span>
                <span class="b_counter--value"><?= $userProfile->streams ?></span>
            </div>
        </div>

    </div>

    <div class="b_profile--layer __friends">

        <h2 class="b_profile--header">Friends</h2>

        <div class="b_profile--friends">
            <?php foreach ($friendProfileList as $friendProfile): ?>
                <?= $this->render(FriendProfile::TEMPLATE, ['friendProfile' => $friendProfile]) ?>
            <?php endforeach; ?>
        </div>

    </div>

</div>
