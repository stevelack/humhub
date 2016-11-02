<div class="container profile-layout-container">
    <div class="row">
        <div class="col-sm-12">
            <?php 

            if($user->group->name != "Mentors"){
                echo \humhub\modules\stats\widgets\CustomProfileHeader::widget(['user' => $user]); 
            }else{
                echo \humhub\modules\stats\widgets\CustomUserProfileHeader::widget(['user' => $user]);
            }
             
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2 layout-nav-container">
            <?= \humhub\modules\user\widgets\ProfileMenu::widget(['user' => $user]); ?>
        </div>

        <?php if (isset($this->context->hideSidebar) && $this->context->hideSidebar) : ?>
            <div class="col-sm-10 layout-content-container">
                <?php //echo $content; ?>
            </div>
        <?php else: ?>
            <div class="col-sm-7 layout-content-container">

	            <div class="panel panel-default">
				    <div class="panel-heading">
				        <h4 style="margin-top:10px"><strong><?php echo Yii::t('MissionsModule.base', 'Achievements'); ?></strong></h4>
				    </div>
				    <div class="panel-body">

				    	<?php foreach($achievements as $a): ?>
				    		<?php if($a->userAchievements): ?>

				    			<!-- <div class="circle">
				    				<i class="fa fa-trophy fa-2x" aria-hidden="true"></i>
				    				<span class="info">123.456.7890</span>
				    			</div> -->

				    			<!-- <div class="trophy">
				    				<div class="t-icon"><i class="fa fa-trophy fa-2x" aria-hidden="true"></i></div>
				    				<div class="t-title"><?php echo $a->title; ?></div>
				    			</div> -->

				    			<div class="trophy-1">
				    				<div class="t-icon"><i class="fa fa-trophy fa-2x" aria-hidden="true"></i></div>
				    				<div class="t-titles"><span><?php echo $a->title; ?></span></div>
				    			</div>

				    		<?php else: ?>
				    			
				    			<!-- <div class="trophy">
				    				<div class="t-icon"><i class="fa fa-trophy fa-2x" aria-hidden="true"></i></div>
				    				<span><?php echo $a->title; ?></span>
				    			</div> -->

				    			<div class="trophy-1">
				    				<div class="t-icon"><i class="fa fa-trophy fa-2x" aria-hidden="true"></i></div>
				    				<div class="t-titles"><span><?php echo $a->title; ?></span></div>
				    			</div>

				    		<?php endif; ?>
				    		
				    	<?php endforeach; ?>

				    </div>
			    </div>

            </div>
            <div class="col-sm-3 layout-sidebar-container">
                <?php
                echo \humhub\modules\user\widgets\ProfileSidebar::widget([
                    'user' => $user,
                    'widgets' => [
                        [\humhub\modules\user\widgets\UserTags::className(), ['user' => $user], ['sortOrder' => 10]],
                        [\humhub\modules\user\widgets\UserSpaces::className(), ['user' => $user], ['sortOrder' => 20]],
                        [\humhub\modules\user\widgets\UserFollower::className(), ['user' => $user], ['sortOrder' => 30]],
                    ]
                ]);
                ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>

.trophy{
	line-height: 82px; margin-bottom:20px;
}

.t-icon{
	float: left; background-color: #19B8B8; padding: 25px; border-radius: 50%; line-height: 10px; opacity: 0.99; color: #F8F8F8;
}

.t-title{
	background-color: #34DADA; padding: 15px 40px; margin-left: -10px; color: #254054; font-weight: 700; display:inline; width: 100%;
}

.trophy-1{
	line-height: 82px; margin-bottom:20px; background-color: #34DADA;     padding: 10px 15px 5px;
}

.t-titles{
	/*background-color: #34DADA;*/
    color: #254054;
    font-weight: 700;
    display: inline-block;
    width: 50%;
    margin-top: -9px;
    vertical-align: middle;
    text-align: right;
    
	/*    background-color: #34DADA;
    padding: 15px 40px;
    margin-left: -15px;
    color: #254054;
    font-weight: 700;
    display: inline-block;
    width: 50%;
    height: 50px;
    margin-top: -9px;
    vertical-align: middle;
    display: inline-block;*/
}

.t-titles span{
	font-size: 12pt;
	margin-left:50px;
}

.trophy-title{
	display: inline-block;
    background-color: green;
    padding: 12px;
    margin-left: -14px;
    margin-top: -10px;
    width:200px;
}

/*.circle{width:100px;height:100px;border-radius:50px;font-size:20px;color:#fff;line-height:100px;text-align:center;background:#000}*/

.circle{
	width: 70px;
    height: 70px;
    border-radius: 50%;
    font-size: 12pt;
    color: #eee;
    line-height: 70px;
    text-align: center;
    background: #1ECCCC;
}

.circle i{
	line-height: 70px;
}

.info{position:absolute;color:#254054;margin-left:30px}

.info-grayed{position:absolute;color:#999;margin-left:30px}

</style>