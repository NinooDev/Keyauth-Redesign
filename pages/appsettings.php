<?php
include '../../../includes/connection.php';
include '../includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']))
{
    header("Location: ../auth/login.php");
    exit();
}

$_SESSION['role'] = $role;

    if ($role == "Reseller")
    {
        die('Resellers Not Allowed Here');
    }
?>
<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">
	
<form method="post">
<button data-bs-toggle="modal" type="button" data-bs-target="#reset-hash" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-redo-alt fa-sm text-white-50"></i> Reset program hash</button>  
<button data-bs-toggle="modal" type="button" data-bs-target="#add-hash" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Add hash</button>
</form>
                                        <br>

<div id="add-hash" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
												<h4 class="modal-title">Add hash</h4>
                                                    <!--begin::Close-->
                                                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                            <span class="svg-icon svg-icon-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    <!--end::Close-->                                              </div>
                                            <div class="modal-body">
                                                <form method="post">
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Application hash:</label>
                                                        <input type="text" class="form-control" name="hash" placeholder="MD5 program hash to add">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-danger waves-effect waves-light" name="addhash">Add</button>
												</form>
                                            </div>
                          </div>
                                    </div>
                                        <br>
									</div>

<div class="modal fade" tabindex="-1" id="reset-hash">
   	<!--begin::Modal dialog-->
       <div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Reset Hash</h2>

                <!--begin::Close-->
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
									<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
								</svg>
							</span>
						</div>
				<!--end::Close-->
            </div>
            <div class="modal-body">
                <label class="fs-5 fw-bold mb-2">
                <p> Are you sure you want to reset hash? Only do if you're releasing new program. </p>
                </label>
            </div>									
            <div class="modal-footer">
                <form method="post">
                <button  class="btn btn-light" data-bs-dismiss="modal">No</button>
                <button  name="resethash" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
	
<?php
		if($_SESSION['app'])
		{
        ($result = mysqli_query($link, "SELECT * FROM `apps` WHERE `secret` = '".$_SESSION['app']."'")) or die(mysqli_error($link));
        if (mysqli_num_rows($result) > 0)
            {
                while ($row = mysqli_fetch_array($result))
                {
                    
					$enabled = $row['enabled'];
					$hwidcheck = $row['hwidcheck'];
					$vpnblock = $row['vpnblock'];
					$panelstatus = $row['panelstatus'];
					$hashcheck = $row['hashcheck'];

                    $verr = $row['ver'];
                    $dll = $row['download'];
                    $webdll = $row['webdownload'];
                    $wh = $row['webhook'];
                    $rs = $row['resellerstore'];
                    $appname = $row["name"];
					
                    $sellixwhsecret = $row['sellixsecret'];
                    $sellixdayproduct = $row['sellixdayproduct'];
                    $sellixweekproduct = $row['sellixweekproduct'];
                    $sellixmonthproduct = $row['sellixmonthproduct'];
                    $sellixlifetimeproduct = $row['sellixlifetimeproduct'];
					
					$shoppywhsecret = $row['shoppysecret'];
                    $shoppydayproduct = $row['shoppydayproduct'];
                    $shoppyweekproduct = $row['shoppyweekproduct'];
                    $shoppymonthproduct = $row['shoppymonthproduct'];
                    $shoppylifetimeproduct = $row['shoppylifetimeproduct'];
					
					$appdisabled = $row['appdisabled'];
					$usernametaken = $row['usernametaken'];
					$keynotfound = $row['keynotfound'];
					$keyused = $row['keyused'];
					$nosublevel = $row['nosublevel'];
					$usernamenotfound = $row['usernamenotfound'];
					$passmismatch = $row['passmismatch'];
					$hwidmismatch = $row['hwidmismatch'];
					$noactivesubs = $row['noactivesubs'];
					$hwidblacked = $row['hwidblacked'];
					$pausedsub = $row['pausedsub'];
					$keyexpired = $row['keyexpired'];
					$vpnblocked = $row['vpnblocked'];
					$keybanned = $row['keybanned'];
					$userbanned = $row['userbanned'];
					$sessionunauthed  = $row['sessionunauthed'];
					$hashcheckfail  = $row['hashcheckfail'];
                }
            }
		}

?>
 <div class="card">
                            <div class="card-body">
                                <form class="form" method="post">
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-2 col-form-label">Status <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Allow people to open application or not"></i></label>
                                        <div class="col-10">
											<select class="form-control" name="statusinput">
                                                <option value="0" <?=$enabled == 0 ? ' selected="selected"' : '';?>>Disabled</option>
                                                <option value="1" <?=$enabled == 1 ? ' selected="selected"' : '';?>>Enabled</option>
											</select>
                                        </div>
                                    </div>
                                        <br>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-2 col-form-label">HWID Lock <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Lock user to a value from your user's computer which only changes if they reinstall windows. Use this to prevent people sharing your product"></i></label>
                                        <div class="col-10">
											<select class="form-control" name="hwidinput">
												<option value="0" <?=$hwidcheck == 0 ? ' selected="selected"' : '';?>>Disabled</option>
                                                <option value="1" <?=$hwidcheck == 1 ? ' selected="selected"' : '';?>>Enabled</option>
                                            </select>
                                         </div>
                                    </div>
                                        <br>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-2 col-form-label">VPN Block <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Block suspected VPNs. Message DisMail if you need us to whitelist an IP if it's being falsely detected as a VPN. Provide the IPV4 address, not IPV6."></i></label>
                                        <div class="col-10">
											<select class="form-control" name="vpninput">
												<option value="0" <?=$vpnblock == 0 ? ' selected="selected"' : '';?>>Disabled</option>
                                                <option value="1" <?=$vpnblock == 1 ? ' selected="selected"' : '';?>>Enabled</option>
											</select>
                                        </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-text-input" class="col-2 col-form-label">Hash Check <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Checks whether the application has been modified since the last time you pressed reset hash button. Used to stop people altering your program to bypass it."></i></label>
                                        <div class="col-10">
											<select class="form-control" name="hashinput">
												<option value="0" <?=$hashcheck == 0 ? ' selected="selected"' : '';?>>Disabled</option>
                                                <option value="1" <?=$hashcheck == 1 ? ' selected="selected"' : '';?>>Enabled</option>
											</select>
                                         </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Version <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="If you change this, the download link will be opened on your user's computer when they run the loader with the old version."></i></label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="10" name="version" value="<?php echo $verr; ?>" placeholder="<?php echo $verr; ?>" placeholder="Application Verion..">
                                         </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Download</label>
                                        <div class="col-10">
                                            <input class="form-control" name="download" value="<?php echo $dll; ?>" type="text" placeholder="URL Link That Will Be Opened If Version doesn't match (auto update)">
                                         </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Web Download</label>
                                        <div class="col-10">
                                            <input class="form-control" name="webdownload" value="<?php echo $webdll; ?>" type="text" placeholder="URL link for web loader (this will enable web loader if not empty)">
                                        </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Webhook <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="This is where you put Discord webhooks, not the webhooks page."></i></label>
                                        <div class="col-10">
                                            <input class="form-control" name="webhook" value="<?php echo $wh; ?>" type="text" placeholder="Discord Webhook Link For Sending Notifications & Logs">
                                         </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Reseller Store <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="If you're not using built-in reseller system, set a link will show to your resellers for them to buy keys."></i></label>
                                        <div class="col-10">
                                            <input class="form-control" name="resellerstore" value="<?php echo $rs; ?>" placeholder="If you don't want to use the inbuilt store for resellers, set a store link." type="text">
                                         </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-text-input" class="col-2 col-form-label">Customer Panel <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Allows your customers to log in with their username and password (which if using just key is the same) and reset their HWID and download latest application from KeyAuth website"></i></label>
                                        <div class="col-10">
											<select class="form-control" name="panelstatus">
												<option value="0" <?=$panelstatus == 0 ? ' selected="selected"' : '';?>>Disabled</option>
                                                <option value="1" <?=$panelstatus == 1 ? ' selected="selected"' : '';?>>Enabled</option>
											</select>
                                         </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Customer panel link</label>
                                        <div class="col-10">
                                            <label class="form-control" style="height:auto;"><?php
                                            echo '<a href="https://'.($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME']).'/panel/'.$_SESSION['username'].'/'.$appname.'" target="_blank">https://'.($_SERVER['SERVER_NAME'] ?? $_SERVER['HTTP_HOST']).'/panel/'.$_SESSION['username'].'/'.$appname.'</a>';
											?></label>
                                         </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">HWID Reset Cooldown Unit: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Delay between the last time your customer reset their HWID to when they can reset again. That way, they can't reset it once, allow their friend to login, and then reset it again for themselves."></i></label>
                                        <div class="col-10">
										<select name="cooldownexpiry" class="form-control"><option value="86400">Days</option><option value="60">Minutes</option><option value="3600">Hours</option><option value="1">Seconds</option><option value="604800">Weeks</option><option value="2629743">Months</option><option value="31556926">Years</option><option value="315569260">Lifetime</option></select>
										</div>
									</div>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">HWID Reset Cooldown Duration:</label>
                                        <div class="col-10">
										<input name="cooldownduration" type="number" class="form-control" placeholder="Multiplied by selected cooldown unit">
										</div>
                                    </div>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Session Expiry Unit: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="This is how long your users can stay logged in for. After it pasts this time, if you call any functions that require a session it will close the loader."></i></label>
                                        <div class="col-10">
										<select name="sessionexpiry" class="form-control"><option value="86400">Days</option><option value="60">Minutes</option><option value="3600">Hours</option><option value="1">Seconds</option><option value="604800">Weeks</option><option value="2629743">Months</option><option value="31556926">Years</option><option value="315569260">Lifetime</option></select>
										</div>
									</div>
                                                                            <br>

									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Session Expiry Duration:</label>
                                        <div class="col-10">
										<input name="sessionduration" type="number" class="form-control" placeholder="Multiplied by selected expiry unit">
										</div>
                                    </div>
									                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">App Disabled Msg <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="All the textboxes in this section are the custom error responses. Success messages aren't custom since you shouldn't need to show it."></i></label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="100" name="appdisabled" id="defaultconfig-3" value="<?php echo $appdisabled; ?>" placeholder="Custom response you'd like. Max 100 chars">
                                        </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Hash check Msg</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="100" name="hashcheckfail" id="defaultconfig-3" value="<?php echo $hashcheckfail; ?>" placeholder="Custom response you'd like. Max 100 chars">
                                       </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">VPN Blocked Msg</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="100" name="vpnblocked" id="defaultconfig-3" value="<?php echo $vpnblocked; ?>" placeholder="Custom response you'd like. Max 100 chars">
                                        </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Username Taken Msg</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="100" name="usernametaken" id="defaultconfig-3" value="<?php echo $usernametaken; ?>" placeholder="Custom response you'd like. Max 100 chars">
                                          </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Invalid Key Msg</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="100" name="keynotfound" id="defaultconfig-3" value="<?php echo $keynotfound; ?>" placeholder="Custom response you'd like. Max 100 chars">
                                          </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Used Key Msg</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="100" name="keyused" id="defaultconfig-3" value="<?php echo $keyused; ?>" placeholder="Custom response you'd like. Max 100 chars">
                                          </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Key Banned Msg</label>
                                        <div class="col-10">
                                        <input class="form-control" maxlength="100" name="keybanned" id="defaultconfig-3" value="<?php echo $keybanned; ?>" placeholder="Custom response you'd like. Max 100 chars">
                                          </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">No Subs Msg</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="100" name="nosublevel" id="defaultconfig-3" value="<?php echo $nosublevel; ?>" placeholder="Custom response you'd like. Max 100 chars">
                                          </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">User Banned Msg</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="100" name="userbanned" id="defaultconfig-3" value="<?php echo $userbanned; ?>" placeholder="Custom response you'd like. Max 100 chars">
                                       </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Username Invalid Msg</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="100" name="usernamenotfound" id="defaultconfig-3" value="<?php echo $usernamenotfound; ?>" placeholder="Custom response you'd like. Max 100 chars">
                                          </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Password Mismatch Msg</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="100" name="passmismatch" id="defaultconfig-3" value="<?php echo $passmismatch; ?>" placeholder="Custom response you'd like. Max 100 chars">
                                         </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Hwid Mismatch Msg</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="100" name="hwidmismatch" id="defaultconfig-3" value="<?php echo $hwidmismatch; ?>" placeholder="Custom response you'd like. Max 100 chars">
                                          </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Expired Sub Msg</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="100" name="noactivesubs" id="defaultconfig-3" value="<?php echo $noactivesubs; ?>" placeholder="Custom response you'd like. Max 100 chars">
                                       </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Blacklisted Msg</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="100" name="hwidblacked" id="defaultconfig-3" value="<?php echo $hwidblacked; ?>" placeholder="Custom response you'd like. Max 100 chars">
                                       </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Paused Msg</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="100" name="pausedsub" id="defaultconfig-3" value="<?php echo $pausedsub; ?>" placeholder="Custom response you'd like. Max 100 chars">
                                         </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Session Unauthenticated Msg</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="100" name="sessionunauthed" id="defaultconfig-3" value="<?php echo $sessionunauthed; ?>" placeholder="Custom response you'd like. Max 100 chars">
                                        </div>
                                    </div>
                                        <br>
                                        <br>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Reseller Webhook Link <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="This is the same if you're using Sellix or Shoppy, create webhook with this link for the event order:paid"></i></label>
                                        <div class="col-10">
                                            <label class="form-control" style="height:auto;"><?php echo '<a href="https://'.($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME']).'/api/reseller/?app='.$_SESSION['secret'].'" target="target_" class="secretlink">https://'.($_SERVER['SERVER_NAME'] ?? $_SERVER['HTTP_HOST']).'/api/reseller/?app='.$_SESSION['secret'].'</a>';?></label>
                                         </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Shoppy Webhook Secret <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Shoppy webhook secret for reseller system"></i></label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="16" name="shoppywebhooksecret" value="<?php echo $shoppywhsecret; ?>" id="defaultconfig-3" placeholder="Webhook secret found in General Shop Settings on Shoppy">
                                          </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Shoppy Day Product ID</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="7" name="shoppydayproduct" value="<?php echo $shoppydayproduct; ?>" id="defaultconfig-3" placeholder="Product ID of Day Reseller Key Shoppy Product">
                                       </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Shoppy Week Product ID</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="7" name="shoppyweekproduct" value="<?php echo $shoppyweekproduct; ?>" id="defaultconfig-3" placeholder="Product ID of Week Reseller Key Shoppy Product">
                                          </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Shoppy Month Product ID</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="7" name="shoppymonthproduct" value="<?php echo $shoppymonthproduct; ?>" id="defaultconfig-3" placeholder="Product ID of Month Reseller Key Shoppy Product">
                                         </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Shoppy Lifetime Product ID</label>
                                        <div class="col-10">
                                         <input class="form-control" maxlength="7" name="shoppylifetimeproduct" value="<?php echo $shoppylifetimeproduct; ?>" id="defaultconfig-3" placeholder="Product ID of Lifetime Reseller Key Shoppy Product">
                                      </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Sellix Webhook Secret <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Sellix webhook secret for reseller system"></i></label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="32" name="sellixwebhooksecret" value="<?php echo $sellixwhsecret; ?>" id="defaultconfig-3" placeholder="Webhook secret found in General Shop Settings on Sellix">
                                         </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Sellix Day Product ID</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="13" name="sellixdayproduct" value="<?php echo $sellixdayproduct; ?>" id="defaultconfig-3" placeholder="Product ID of Day Reseller Key Sellix Product">
                                          </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Sellix Week Product ID</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="13" name="sellixweekproduct" value="<?php echo $sellixweekproduct; ?>" id="defaultconfig-3" placeholder="Product ID of Week Reseller Key Sellix Product">
                                          </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Sellix Month Product ID</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="13" name="sellixmonthproduct" value="<?php echo $sellixmonthproduct; ?>" id="defaultconfig-3" placeholder="Product ID of Month Reseller Key Sellix Product">
                                         </div>
                                    </div>
                                        <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Sellix Lifetime Product ID</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="13" name="sellixlifetimeproduct" value="<?php echo $sellixlifetimeproduct; ?>" id="defaultconfig-3" placeholder="Product ID of Lifetime Reseller Key Sellix Product">
                                         </div>
                                    </div>
                                        <br>
                                    <button name="updatesettings" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <?php
if(isset($_POST['addhash']))
{
	$hash = sanitize($_POST['hash']);
    $result = mysqli_query($link, "SELECT `hash` FROM `apps` WHERE `secret` = '".$_SESSION['app']."'");
    $row = mysqli_fetch_array($result);
    $oldHash = $row["hash"];

    $newHash = $oldHash .= $hash;

    mysqli_query($link, "UPDATE `apps` SET `hash` = '$newHash' WHERE `secret` = '".$_SESSION['app']."'");
	success("Successfully added hash!");
    echo "<meta http-equiv='Refresh' Content='2;'>";
}

if(isset($_POST['resethash']))
{
	mysqli_query($link, "UPDATE `apps` SET `hash` = NULL WHERE `secret` = '".$_SESSION['app']."'");
	success("Successfully reset hash!");
    echo "<meta http-equiv='Refresh' Content='2;'>";
}
	
if(isset($_POST['updatesettings']))
{
    $status = sanitize($_POST['statusinput']);
    $hwid = sanitize($_POST['hwidinput']);
    $vpn = sanitize($_POST['vpninput']);
    $hashstatus = sanitize($_POST['hashinput']);
    $ver = sanitize($_POST['version']);
    $dl = sanitize($_POST['download']);
    $webdl = sanitize($_POST['webdownload']);
    $webhooker = sanitize($_POST['webhook']);
    $resellerstorelink = sanitize($_POST['resellerstore']);
	$panelstatus = sanitize($_POST['panelstatus']);
	
	$cooldownduration = sanitize($_POST['cooldownduration']);
	$cooldownexpiry = sanitize($_POST['cooldownexpiry']);
	
	$sessionduration = sanitize($_POST['sessionduration']);
	$sessionexpiry = sanitize($_POST['sessionexpiry']);
 
    ($result = mysqli_query($link, "UPDATE `apps` SET `enabled` = '$status',`hashcheck` = '$hashstatus', `hwidcheck` = '$hwid',`vpnblock` = '$vpn', `ver` = '$ver', `download` = NULLIF('$dl', ''),`webdownload` = NULLIF('$webdl', ''), `webhook` = NULLIF('$webhooker', ''), `resellerstore` = NULLIF('$resellerstorelink', ''),`panelstatus` = '$panelstatus' WHERE `secret` = '".$_SESSION['app']."'")) or die(mysqli_error($link));
	
	
	$appdisabledpost = sanitize($_POST['appdisabled']);
	$usernametakenpost = sanitize($_POST['usernametaken']);
	$keynotfoundpost = sanitize($_POST['keynotfound']);
	$keyusedpost = sanitize($_POST['keyused']);
	$nosublevelpost = sanitize($_POST['nosublevel']);
	$usernamenotfoundpost = sanitize($_POST['usernamenotfound']);
	$passmismatchpost = sanitize($_POST['passmismatch']);
	$hwidmismatchpost = sanitize($_POST['hwidmismatch']);
	$noactivesubspost = sanitize($_POST['noactivesubs']);
	$hwidblackedpost = sanitize($_POST['hwidblacked']);
	$pausedsubpost = sanitize($_POST['pausedsub']);
	$vpnblockedpost = sanitize($_POST['vpnblocked']);
	$keybannedpost = sanitize($_POST['keybanned']);
	$userbannedpost = sanitize($_POST['userbanned']);
	$sessionunauthedpost = sanitize($_POST['sessionunauthed']);
	$hashcheckfailpost = sanitize($_POST['hashcheckfail']);
	
	($result = mysqli_query($link, "UPDATE `apps` SET `appdisabled` = '$appdisabledpost', `hashcheckfail` = '$hashcheckfailpost', `sessionunauthed` = '$sessionunauthedpost',`userbanned` = '$userbannedpost', `vpnblocked` = '$vpnblockedpost', `keybanned` = '$keybannedpost', `usernametaken` = '$usernametakenpost', `keynotfound` = '$keynotfoundpost',`keyused` = '$keyusedpost', `nosublevel` = '$nosublevelpost', `usernamenotfound` = '$usernamenotfoundpost', `passmismatch` = '$passmismatchpost', `hwidmismatch` = '$hwidmismatchpost', `noactivesubs` = '$noactivesubspost', `hwidblacked` = '$hwidblackedpost', `pausedsub` = '$pausedsubpost' WHERE `secret` = '".$_SESSION['app']."'")) or die(mysqli_error($link));
    
	$shoppywebhooksecret = sanitize($_POST['shoppywebhooksecret']);
	$shoppyday = sanitize($_POST['shoppydayproduct']);
	$shoppyweek = sanitize($_POST['shoppyweekproduct']);
	$shoppymonth = sanitize($_POST['shoppymonthproduct']);
	$shoppylife = sanitize($_POST['shoppylifetimeproduct']);
	
	$sellixwebhooksecret = sanitize($_POST['sellixwebhooksecret']);
	$sellixday = sanitize($_POST['sellixdayproduct']);
	$sellixweek = sanitize($_POST['sellixweekproduct']);
	$sellixmonth = sanitize($_POST['sellixmonthproduct']);
	$sellixlife = sanitize($_POST['sellixlifetimeproduct']);
	
	($result = mysqli_query($link, "UPDATE `apps` SET `sellixsecret` = NULLIF('$sellixwebhooksecret', ''), `sellixdayproduct` = NULLIF('$sellixday', ''), `sellixweekproduct` = NULLIF('$sellixweek', ''), `sellixmonthproduct` = NULLIF('$sellixmonth', ''),`sellixlifetimeproduct` = NULLIF('$sellixlife', ''),`shoppysecret` = NULLIF('$shoppywebhooksecret', ''), `shoppydayproduct` = NULLIF('$shoppyday', ''), `shoppyweekproduct` = NULLIF('$shoppyweek', ''), `shoppymonthproduct` = NULLIF('$shoppymonth', ''),`shoppylifetimeproduct` = NULLIF('$shoppylife', '') WHERE `secret` = '".$_SESSION['app']."'")) or die(mysqli_error($link));
	
	if(!is_null($cooldownduration))
	{
		$duration = $cooldownduration * $cooldownexpiry;
		mysqli_query($link, "UPDATE `apps` SET `cooldown` = '$duration' WHERE `secret` = '".$_SESSION['app']."'");
	}
	
	if(!is_null($sessionduration))
	{
		$duration = $sessionduration * $sessionexpiry;
		mysqli_query($link, "UPDATE `apps` SET `session` = '$duration' WHERE `secret` = '".$_SESSION['app']."'");
	}
	
    if($result)
    {
        success("Updated Settings!");
        echo "<meta http-equiv='Refresh' Content='2;'>";
    }
}

?>

</div>
<!--end::Container-->
