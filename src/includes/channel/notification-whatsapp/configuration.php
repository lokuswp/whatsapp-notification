<?php
$settings = lwp_get_option( $this->id . "-config" );

$apikey = isset( $settings['token'] ) ? lwp_sanitize( $settings['token'], 'attr' ) : null;
?>

<style>
    /* Action Tab */
    #tab-vendornmae-log:checked ~ .tab-body-wrapper #tab-body-vendornmae-log,
    #tab-vendornmae-settings:checked ~ .tab-body-wrapper #tab-body-vendornmae-settings {
        position: relative;
        top: 0;
        opacity: 1;
    }

    .tab-body-wrapper .table-log th {
        display: inline-block;
    }

    .tab-body-wrapper .table-log tr {
        margin-bottom: 0;
    }

    .tab-body-wrapper .table-log tbody tr td {
        display: inline-block;
        padding: 10px;
    }

    .tab-body-wrapper .table-log.table td,
    .tab-body-wrapper .table-log.table th {
        border-bottom: 0;
    }

    .tab-body-wrapper label.fix {
        margin-top: 3px;
        font-weight: 600;
        float: left;
        padding: 5px 0 !important;
        font-size: 14px;
    }
</style>

<div class="tabs-wrapper">
    <input type="radio" name="vendornmae" id="tab-vendornmae-log" checked="checked"/>
    <label class="tab" for="tab-vendornmae-log"><?php _e( 'Log', 'lokuswp' ); ?></label>

    <input type="radio" name="vendornmae" id="tab-vendornmae-settings"/>
    <label class="tab" for="tab-vendornmae-settings"><?php _e( 'Settings', 'lokuswp' ); ?></label>

    <div class="tab-body-wrapper">

        <!------------ Tab : Test and Log ------------>
        <div id="tab-body-vendornmae-log" class="tab-body">

            <!--			<div class="divider" data-content="Test Notification"></div>-->
            <!--			<div class="input-group" style="width:50%;">-->
            <!--				<input id="lokuswp_vendornmae_test" style="margin-top:3px;" class="form-input input-md"-->
            <!--				       type="text" placeholder="0812387621f812">-->
            <!--				<button id="lokuswp_vendornmae_sendtest" style="margin-top:3px;"-->
            <!--				        class="btn btn-primary input-group-btn">-->
			<?php //_e( 'Test Notification', "lokuswp" ); ?><!--</button>-->
            <!--			</div>-->

            <div class="divider" data-content="Notification Log"></div>
            <table class="table-log table table-striped table-hover">
                <tbody>
				<?php $db = lwp_get_option( $this->id ); ?>
				<?php $log = $db['log'] ?? []; ?>

				<?php if ( $log ) : ?>
					<?php foreach ( array_reverse( $log ) as $key => $value ) : ?>
                        <tr>
                            <td><?php echo lwp_date_format( $value[0], 'j M Y, H:i:s' ); ?></td>
                            <td><?php echo json_encode( $value[1] ); ?></td>
                            <td><?php echo $value[2]; ?></td>
                            <td><?php echo $value[3]; ?></td>
                        </tr>
					<?php endforeach; ?>
				<?php else : ?>
                    <tr>
                        <td><?php _e( 'Empty Log', 'lokuswp' ); ?></td>
                    </tr>
				<?php endif; ?>
                </tbody>
            </table>

        </div>

        <!------------ Tab : Settings ------------>
        <div id="tab-body-vendornmae-settings" class="tab-body">
            <!-- Content Pengaturan -->
            <form class="form-horizontal">

                <!-- Sender Email -->
                <div class="form-group">
                    <div class="col-3 col-sm-12">
                        <label class="form-label" for="apikey"><?php _e( 'Token', "lokuswp-vendornmae" ); ?></label>
                    </div>
                    <div class="col-9 col-sm-12">
                        <input class="form-input" type="password" autocompleted="off" name="token"
                               placeholder="B8as91na12-m1nn1243nS1-n24An1n021" style="width:320px"
                               value="<?= $apikey; ?>">
                    </div>
                </div>

                <button type="button" class="btn btn-primary lokuswp_admin_option_save"
                        option="<?php echo $this->id; ?>-config"
                        style="width:120px"><?php _e( 'Save', "lokuswp" ); ?></button>
            </form>

        </div>
    </div>

</div>

<script>
    // Save Template
    // jQuery(document).on("click", ".lokuswp_vendornmae_template_save", function (e) {
    //     jQuery(this).addClass('loading');
    //     let status = jQuery(this).attr('data-status');
    //     let template = jQuery('.lokuswp_vendornmae_template[data-status="' + status + '"]').val();
    //     let that = this;
    //
    //     jQuery.post(lokuswp_admin.ajax_url, {
    //         action: 'lokuswp_notification_vendornmae_save',
    //         status: status,
    //         template: template,
    //         security: lokuswp_admin.ajax_nonce,
    //     }, function (response) {
    //
    //         if (response.trim() === 'action_success') {
    //             jQuery(that).removeClass('loading');
    //         }
    //
    //     }).fail(function () {
    //         alert('Failed, please check your internet');
    //         location.reload();
    //     });
    // });
    //
    // // On User Sending Test Email
    // jQuery(document).on("click", "#lokuswp_vendornmae_sendtest", function (e) {
    //     const elTextPhone = jQuery('#lokuswp_vendornmae_test');
    //     const that = this;
    //
    //     if (elTextPhone.val() !== '') {
    //         jQuery(this).addClass('loading');
    //         elTextPhone.css('border', 'none');
    //
    //         jQuery.post(lokuswp_admin.ajax_url, {
    //             action: 'lokuswp_notification_vendornmae_test',
    //             phone: elTextPhone.val(),
    //             security: lokuswp_admin.ajax_nonce,
    //         }, function (response) {
    //
    //             if (response.trim() == 200) {
    //                 jQuery(that).removeClass('loading');
    //                 jQuery(that).text("Success");
    //             } else {
    //                 jQuery(that).removeClass('loading');
    //                 jQuery(that).text("Failed");
    //             }
    //
    //         }).fail(function () {
    //             alert('Failed, please check your internet');
    //         });
    //
    //     } else {
    //         elTextPhone.css('border', '1px solid red');
    //     }
    // });
</script>