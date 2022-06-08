<?php
$settings = lwp_get_option( $this->id . '-lwdonation' );

$template_pending_for_user = 'Kepada YTH Bpk/Ibu *{{name}}*
Berikut ini Pesanan Anda :
{{program}}

Total Pembayaran : {{total}}

Silahkan Lakukan Pembayaran
{{payment}}

Salam Hangat
*LokusWP*';


$template_completed_for_user = 'Terimakasih *{{customer}}*
atas donasi yang telah Anda berikan
Donasi {{product}} akan kami sampaikan kepada orang-orang yang membutuhkan

*Semoga menjadi amal ibadah anda dan Tuhan memberi keberkahan*

Salam Hangat
*LokusWP*';


$template_completed_for_admin = 'Donasi Baru Masuk';

$pending_template_for_user   = isset( $settings['pending']['user']['template']['id_ID'] ) ? lwp_sanitize( $settings['pending']['user']['template']['id_ID'] ) : $template_pending_for_user;
$cancelled_template_for_user = isset( $settings['cancelled']['user']['template']['id_ID'] ) ? lwp_sanitize( $settings['cancelled']['user']['template']['id_ID'] ) : null;

$completed_template_for_user  = isset( $settings['completed']['user']['template']['id_ID'] ) ? lwp_sanitize( $settings['completed']['user']['template']['id_ID'] ) : $template_completed_for_user;
$completed_template_for_admin = isset( $settings['completed']['admin']['template']['id_ID'] ) ? lwp_sanitize( $settings['completed']['admin']['template']['id_ID'] ) : $template_completed_for_admin;
?>

<style>
    /* Action Tab */
    #fonnte-tab1:checked ~ .tab-body-wrapper #fonnte-tab-body-1,
    #fonnte-tab2:checked ~ .tab-body-wrapper #fonnte-tab-body-2,
    #fonnte-tab3:checked ~ .tab-body-wrapper #fonnte-tab-body-3 {
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

    span.input-group-addon {
        height: 36px;
    }

    .tabs-wrapper input[type=radio]:checked + label.tab {
        margin-bottom: -2px;
    }
</style>

<h4>Pengaturan Template </h4>
<div class="tabs-wrapper">

    <input type="radio" name="fonnte" id="fonnte-tab1" checked="checked"/>
    <label class="tab" for="fonnte-tab1"><?php _e( 'Pending', 'lokuswp' ); ?></label>

    <input type="radio" name="fonnte" id="fonnte-tab2"/>
    <label class="tab" for="fonnte-tab2"><?php _e( 'Cancelled', 'lokuswp' ); ?></label>

    <input type="radio" name="fonnte" id="fonnte-tab3"/>
    <label class="tab" for="fonnte-tab3"><?php _e( 'Completed', 'lokuswp' ); ?></label>

    <div class="tab-body-wrapper">

        <!------------ Tab : Log ------------>
        <div id="fonnte-tab-body-1" class="tab-body">

            <form>
                <h6><?php _e( "Untuk Donatur", "lokuswp-fonnte" ); ?></h6>
                <textarea class="form-input"
                          name="pending[user][template][id_ID]"
                          placeholder="<?= $pending_template_for_user; ?>"
                          rows="9"><?= $pending_template_for_user; ?>
                </textarea>

                <button style="margin-top:12px" class="btn btn-primary input-group-btn lokuswp_admin_option_array_save"
                        option="<?= $this->id ?>-lwdonation">
					<?php _e( 'Simpan', 'lokuswp' ); ?>
                </button>

            </form>

        </div>

        <!------------ Tab : Cancelled ------------>
        <div id="fonnte-tab-body-2" class="tab-body">

            <form>
                <h6><?php _e( "Untuk Donatur", "lokuswp-fonnte" ); ?></h6>
                <textarea class="form-input"
                          name="cancelled[user][template][id_ID]"
                          placeholder="<?= $cancelled_template_for_user; ?>"
                          rows="9"><?= $cancelled_template_for_user; ?></textarea>

                <button style="margin-top:12px" class="btn btn-primary input-group-btn lokuswp_admin_option_array_save"
                        option="<?= $this->id ?>-lwdonation">
					<?php _e( 'Simpan', 'lokuswp' ); ?>
                </button>

            </form>

        </div>

        <!------------ Tab : On Unpaid ------------>
        <div id="fonnte-tab-body-3" class="tab-body">

            <form>
                <h6><?php _e( "Untuk Donatur", "lokuswp-fonnte" ); ?></h6>
                <textarea class="form-input"
                          name="completed[user][template][id_ID]"
                          placeholder="<?= $completed_template_for_user; ?>"
                          rows="9"><?= $completed_template_for_user; ?></textarea>

                <br>

                <h6><?php _e( "Untuk Admin", "lokuswp-fonnte" ); ?></h6>
                <textarea class="form-input"
                          name="completed[admin][template][id_ID]"
                          placeholder="<?= $completed_template_for_admin; ?>"
                          rows="9"><?= $completed_template_for_admin; ?></textarea>

                <button style="margin-top:12px" class="btn btn-primary input-group-btn lokuswp_admin_option_array_save"
                        option="<?= $this->id ?>-lwdonation">
					<?php _e( 'Simpan', 'lokuswp' ); ?>
                </button>

            </form>

        </div>

    </div>
</div>

<script>
    // On Email Editor Save
    // jQuery(document).on("click", ".lokuswp_notification_email_save", function (e) {
    //     jQuery(this).addClass('loading');
    //     let status = jQuery(this).attr('data-status');
    //     let that = this;
    //
    //     jQuery.post(lokuswp_admin.ajax_url, {
    //         action: 'lokuswp_notification_email_template',
    //         status: status,
    //         subject: jQuery('input[name="' + status + '_subject"').val(),
    //         security: lokuswp_admin.ajax_nonce,
    //     }, function (response) {
    //
    //         if (response.trim() == 'action_success') {
    //             jQuery(that).removeClass('loading');
    //         }
    //
    //     }).fail(function () {
    //         alert('Failed, please check your internet');
    //     });
    // });

    // On User Sending Test Email
    // jQuery(document).on("click", "#lokuswp_email_sendtest", function (e) {
    //
    //     const emailTest = jQuery('#lokuswp_email_test');
    //
    //     if (validateEmail(emailTest.val()) && emailTest.val() !== '') {
    //
    //         jQuery(this).addClass('loading');
    //         emailTest.css('border', 'none');
    //
    //         jQuery.post(lokuswp_admin.ajax_url, {
    //             action: 'lokuswp_notification_email_test',
    //             email: emailTest.val(),
    //             security: lokuswp_admin.ajax_nonce,
    //         }, function (response) {
    //
    //             // Reload on Success
    //             if (response.trim() === 'action_success') {
    //                 location.reload();
    //             }
    //
    //         }).fail(function () {
    //             alert('Failed, please check your internet');
    //         });
    //
    //     } else {
    //         emailTest.css('border', '1px solid red');
    //     }
    // });
</script>