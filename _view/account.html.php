<h1><?php echo t($contr->pageTitle) ?></h1>

<?php if ( $model->session->get('user auth') >= user::admin ): ?>
<?php if ( $view->action == 'edit' ): ?>
<h2><?php echo $model->t('Edit account') ?></h2>

<p>
	<a href="./?action=create"><?php echo $model->t('Create a new account') ?></a> 
	<?php if ( $model->session->get('user auth') > $view->userAuth ): ?>
	<a href="./?action=delete&id=<?php echo $view->userId ?>"><?php echo $model->t('Delete this account') ?></a>
	<?php endif ?>
</p>

<?php else: ?>
<h2><?php echo $model->t('New account') ?></h2>
<?php endif ?>
<?php endif ?>

<?php if ( !empty($view->error) ): ?>
<p class="message error"><?php echo $view->error ?></p>
<?php endif ?>

<?php if ( !empty($view->notice) ): ?>
<p class="message notice"><?php echo $view->notice ?></p>
<?php endif ?>

<form id="formAccount" method="post" action="" autocomplete="off">
	<fieldset>
		<?php if ( $view->action == 'edit' ): ?>
		<dl>
			<dt><?php echo t('Id') ?></dt>
			<dd>
				<?php echo $view->userId ?>
			</dd>
		</dl>
		<?php endif ?>
		<dl>
			<dt><label for="username"><?php echo t('Username') ?></label></dt>
			<dd>
				<?php if ( $model->session->get('user auth') >= user::admin ): ?>
				<input type="text" class="text" name="username" id="username" value="<?php echo $model->POST_html_safe['username'] ?>"/>
				<?php else: ?>
				<?php echo $view->userUsername ?>
				<?php endif ?>
				
				<?php if ( isset($model->form->errors['username']) ): ?>
				<span class="error"><?php echo $model->form->errors['username'] ?></span>
				<?php endif ?>
			</dd>
		</dl>
		<dl>
			<dt><label for="password"><?php echo t('Password') ?> (2x)</label></dt>
			<dd>
				<input type="password" class="password" name="password" id="password"/>
				
				<?php if ( isset($model->form->errors['password']) ): ?>
				<span class="error"><?php echo $model->form->errors['password'] ?></span>
				<?php endif ?>
			</dd>
		</dl>
		<dl>
			<dt><br/></dt>
			<dd>
				<input type="password" class="password" name="password_confirm" id="password_confirm"/>
				
				<?php if ( isset($model->form->errors['password_repeat']) ): ?>
				<span class="error"><?php echo $model->form->errors['password_repeat'] ?></span>
				<?php endif ?>
			</dd>
		</dl>
		<dl>
			<dt><label for="email"><?php echo t('E-mail address') ?></label></dt>
			<dd>
				<input type="text" class="text" name="email" id="email" value="<?php echo $model->POST_html_safe['email'] ?>"/>
				
				<?php if ( isset($model->form->errors['email']) ): ?>
				<span class="error"><?php echo t('Invalid e-mail address') ?></span>
				<?php endif ?>
			</dd>
		</dl>
		<dl>
			<dt><label for="auth"><?php echo t('Authorisation level') ?></label></dt>
			<dd>
				<?php if ( $view->action == 'create' || ( $model->session->get('user auth') >= user::admin && $model->session->get('user auth') > $view->userAuth ) ): ?>
				<select name="auth" id="auth">
					<option value="-1"<?php echo $model->POST_html_safe['auth'] == -1 ? ' selected="selected"' : '' ?>><?php echo t('Banned') ?></option>
					<option value="1"<?php  echo $model->POST_html_safe['auth'] == 1 || !$model->POST_html_safe['auth'] ? ' selected="selected"' : '' ?>><?php echo t('User') ?></option>
					<option value="2"<?php  echo $model->POST_html_safe['auth'] == 2  ? ' selected="selected"' : '' ?>><?php echo t('Editor') ?></option>
					<option value="3"<?php  echo $model->POST_html_safe['auth'] == 3  ? ' selected="selected"' : '' ?>><?php echo t('Administrator') ?></option>
					
					<?php if ( $model->session->get('user auth') >= user::admin && $model->session->get('user auth') > $view->userAuth ): ?>
					<option value="4"<?php  echo $model->POST_html_safe['auth'] == 4  ? ' selected="selected"' : '' ?>><?php echo t('Owner') ?></option>
					<?php endif ?>
					
					<?php if ( $model->session->get('user auth') >= user::dev && $model->session->get('user auth') > $view->userAuth ): ?>
					<option value="5"<?php  echo $model->POST_html_safe['auth'] == 5  ? ' selected="selected"' : '' ?>><?php echo t('Developer') ?></option>
					<?php endif ?>
				</select>
				<?php else: ?>
				<?php echo t($view->authLevels[$view->userAuth]) ?>
				<?php endif ?>
			</dd>
		</dl>
	</fieldset>
	<?php if ( $view->prefs ): ?>
	<fieldset>
		<?php foreach ( $view->prefs as $pref ): ?>
		<dl>
			<dt><label for="pref-<?php echo $pref['id'] ?>"><?php echo t($pref['pref']) ?></label></dt>
			<dd>
				<?php
				switch ( $pref['type'] )
				{
					case 'select':
						?>
						<select name="pref-<?php echo $pref['id'] ?>" id="pref-<?php echo $pref['id'] ?>">
						<option value="" ><?php echo t('Select&hellip;') ?></option>
						<?php foreach ( $pref['values'] as $value ): ?>
						<option value="<?php echo h($value) ?>" <?php echo h($value) == $model->POST_html_safe['pref-' . $pref['id']] ? 'selected="selected"' : '' ?>><?php echo h(t($value)) ?></option>
						<?php endforeach ?>
						</select>
						<?php
						
						break;
					case 'text':
						?>
						<input type="text" class="text" name="pref-<?php echo $pref['id'] ?>" id="pref-<?php echo $pref['id'] ?>" value="<?php echo $model->POST_html_safe['pref-' . $pref['id']] ?>"/>
						<?php

						break;
					case 'checkbox':
						?>
						<input type="checkbox" class="checkbox" name="pref-<?php echo $pref['id'] ?>" id="pref-<?php echo $pref['id'] ?>" value="1" <?php echo $model->POST_html_safe['pref-' . $pref['id']] ? 'checked="checked"' : '' ?>"/>
						<?php

						break;
				}
				?>

				<?php if ( isset($model->form->errors['pref-' . $pref['id']]) ): ?>
				<span class="error"><?php echo t('Invalid') ?></span>
				<?php endif ?>
			</dd>
		</dl>
		<?php endforeach ?>
	</fieldset>
	<?php endif ?>
	<fieldset>
		<dl>
			<dt><br/></dt>
			<dd>
				<input type="hidden" name="auth_token" value="<?php echo $model->authToken ?>"/>

				<input type="submit" class="button" name="form-submit" id="form-submit" value="<?php echo t('Save settings') ?>"/>
			</dd>
		</dl>
	</fieldset>
</form>

<?php if ( $model->session->get('user auth') >= user::admin ): ?>
<h2><?php echo t('Select an account') ?></h2>

<form id="formUsers" method="get" action="./">
	<fieldset>
		<dl>
			<dt><label for="id"><?php echo t('Username') ?></label></dt>
			<dd>
				<select name="id" id="id" onchange="if ( this.value ) document.getElementById('formUsers').submit();">
					<option value=""><?php echo t('Select&hellip;') ?></option>
					<?php foreach ( $view->users as $id => $username ): ?>
					<option value="<?php echo $id ?>"><?php echo $username ?></option>
					<?php endforeach ?>
				</select>
			</dd>
		</dl>
	</fieldset>
	<fieldset>
		<dl>
			<dt><br/></dt>
			<dd>
				<input type="submit" class="button" id="form-submit2" value="<?php echo t('Ok') ?>"/>
			</dd>
		</dl>
	</fieldset>
</form>
<?php endif ?>

<?php if ( $view->action == 'create' ): ?>
<script type="text/javascript">
	<!-- /* <![CDATA[ */
	// Focus the username field
	$(function() {
		$('#username').focus();
	});
	/* ]]> */ -->
</script>
<?php endif ?>