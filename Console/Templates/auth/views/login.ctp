<div id="logo">
    <img src="/img/logo.png" alt="" />
</div>
<div id="loginbox">
    <form id="loginform" class="form-vertical" action='/<?php echo $pluralHumanName;?>/login' method="post">
        <?php echo '<?php echo $this->Session->flash();?>'; ?>
        <p><?php echo "<?php echo __('Enter username and password to continue.');?>"; ?></p>
        <div class="control-group">
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span><input type="text" name="data[<?php echo $modelClass;?>][email]" placeholder="Email" />
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-lock"></i></span><input type="password" name="data[<?php echo $modelClass;?>][password]" placeholder="Password" />
                </div>
            </div>
        </div>
        <div class="form-actions">
            <span class="pull-left"><a href="#" class="flip-link" id="to-recover"><?php echo "<?php echo __('Lost password?');?>"; ?></a></span>
            <span class="pull-right"><input type="submit" class="btn btn-inverse" value="Login" /></span>
        </div>
    </form>
    <form id="recoverform" action='/<?php echo $modelClass;?>/forgot' class="form-vertical">
        <p><?php echo "<?php echo __('Enter your e-mail address below and we will send you instructions how to recover a password.');?>"; ?></p>
        <div class="control-group">
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-envelope"></i></span><input type="text" name="data[<?php echo $modelClass;?>][email]" placeholder="E-mail address" />
                </div>
            </div>
        </div>
        <div class="form-actions">
            <span class="pull-left"><a href="#" class="flip-link" id="to-login">&lt; <?php echo "<?php echo __('Back to login');?>"; ?></a></span>
            <span class="pull-right"><input type="submit" class="btn btn-inverse" value="Recover" /></span>
        </div>
    </form>
</div>