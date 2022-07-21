<?php
	$page = isset($_GET['page']) ? $_GET['page'] : "index";
?>		
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">

<?php include 'aside/_base.php' ?>

				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

<?php include 'header/_base.php' ?>

					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

<?php include 'toolbars/_toolbar-1.php' ?>

						<!--begin::Post-->
						<div class="post d-flex flex-column-fluid" id="kt_post">

<?php 
	if($page == 'index'){
		include __DIR__ . '/../pages/index.php'; 
	} else if($page == 'licenses')
	{
		include __DIR__ . '/../pages/licenses.php'; 
	} else if($page == 'docs')
	{
		include __DIR__ . '/../pages/docs.php'; 
	}else if($page == 'logout')
	{
		include __DIR__ . '/../auth/logout.php'; 
	}else if($page == 'manage-apps')
	{
		include __DIR__ . '/../pages/manageapps.php'; 
	}else if($page == 'users')
	{
		include __DIR__ . '/../pages/users.php'; 
	}else if($page == 'subscriptions')
	{
		include __DIR__ . '/../pages/subscriptions.php'; 
	}else if($page == 'chats')
	{
		include __DIR__ . '/../pages/chats.php'; 
	}else if($page == 'sessions')
	{
		include __DIR__ . '/../pages/sessions.php'; 
	}else if($page == 'webhooks')
	{
		include __DIR__ . '/../pages/webhooks.php'; 
	}else if($page == 'files')
	{
		include __DIR__ . '/../pages/files.php'; 
	}else if($page == 'vars')
	{
		include __DIR__ . '/../pages/vars.php'; 
	}else if($page == 'logs')
	{
		include __DIR__ . '/../pages/logs.php'; 
	}else if($page == 'blacklists')
	{
		include __DIR__ . '/../pages/blacklists.php'; 
	}else if($page == 'app-settings')
	{
		include __DIR__ . '/../pages/appsettings.php'; 
	}else if($page == 'manage-accs')
	{
		include __DIR__ . '/../pages/manange.php'; 
	}else if($page == 'upgrade')
	{
		include __DIR__ . '/../pages/upgrade.php'; 
	}else if($page == 'account-settings')
	{
		include __DIR__ . '/../pages/accsettings.php'; 
	}else if($page == 'account-logs')
	{
		include __DIR__ . '/../pages/acclogs.php'; 
	}else if($page == 'seller-settings')
	{
		include __DIR__ . '/../pages/seller-settings.php'; 
	}else if($page == 'webloader')
	{
		include __DIR__ . '/../pages/webloader.php'; 
	}else if($page == 'reseller-licenses')
	{
		include __DIR__ . '/../pages/reseller-licenses.php'; 
	}else if($page == 'reseller-users')
	{
		include __DIR__ . '/../pages/reseller-users.php'; 
	}else if($page == 'reseller-balance')
	{
		include __DIR__ . '/../pages/reseller-balance.php'; 
	}
	
	
	
	
	
	
	
	
	else if($page == 'test')
	{
		include __DIR__ . '/../pages/test.php'; 
	}  else {
		//fallback
		include __DIR__ . '/../pages/index.php';
	}
?>

						</div>
						<!--end::Post-->
					</div>
					<!--end::Content-->

<?php include '_footer.php' ?>

				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->

		<!--end::Main-->
		