<?php
	$page = isset($_GET['page']) ? $_GET['page'] : "index";

	$title = "Dashboard";

	if($page == 'index'){
		$title = "Dashboard";
	}else if($page == 'licenses'){
		$title = "Licenses";
	}else if($page == 'docs'){
		$title = "Documentation";
	}else if($page == 'manage-apps'){
		$title = "Manage Applications";
	}else if($page == 'users'){
		$title = "Users";
	}else if($page == 'subscriptions'){
		$title = "Subscriptions";
	}else if($page == 'chats'){
		$title = "Chats";
	}else if($page == 'sessions'){
		$title = "Sessions";
	}else if($page == 'webhooks'){
		$title = "Webhooks";
	}else if($page == 'files'){
		$title = "Files";
	}else if($page == 'vars'){
		$title = "Variables";
	}else if($page == 'logs'){
		$title = "Logs";
	}else if($page == 'blacklists'){
		$title = "Blacklists";
	}else if($page == 'app-settings'){
		$title = "Application Settings";
	}else if($page == 'manage-accs'){
		$title = "Manage";
	}else if($page == 'upgrade'){
		$title = "Upgrade";
	}else if($page == 'account-settings'){
		$title = "Account Settings";
	}else if($page == 'account-logs'){
		$title = "Account Logs";
	}else if($page == 'seller-settings'){
		$title = "Seller Settings";
	}else if($page == 'webloader'){
		$title = "Web Loader";
	}else if($page == 'reseller-licenses'){
		$title = "Licenses";
	}else if($page == 'reseller-users'){
		$title = "Users";
	}else if($page == 'reseller-balance'){
		$title = "Balance";
	}
?>		
								<!--begin::Page title-->
								<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
									<!--begin::Title-->
									<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"><?php echo $title; ?>
									<!--begin::Separator-->
									<span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
									</h1>
									<!--end::Title-->
								</div>
								<!--end::Page title-->
								