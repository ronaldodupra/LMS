    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="<?php echo base_url();?>style/js/picker.js"></script>
        <script src="<?php echo base_url();?>style/js/picker.en.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/bootstrap-clockpicker/bootstrap-clockpicker.min.js"></script>
    <script type="text/javascript">
        $('.clockpicker').clockpicker({
            placement: 'top',
            align: 'left',
            donetext: 'Done'
        });
    </script>

<?php if ($this->session->flashdata('flash_message') != ""):?>
        <script>
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 8000
            }); 
            Toast.fire({
            type: 'success',
            title: '<?php echo $this->session->flashdata("flash_message");?>'
            })
        </script>
    <?php endif;?>
    
     <script>
    $(document).ready(function() {
        if ($("#mymce").length > 0) {
            tinymce.init({
                selector: "textarea#mymce",
                theme: "modern",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

            });
        }

        if ($("#mymce_news").length > 0) {
            tinymce.init({
                selector: "textarea#mymce_news",
                theme: "modern",
                height: 230,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent |  media fullpage preview",
            });
        }
    });
    </script>
    <script src="<?php echo base_url();?>style/cms/bower_components/jquery/dist/jquery.min.js"></script>
    <script src='<?php echo base_url();?>style/fullcalendar/js/jquery.js'></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/moment/moment.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/tether/dist/js/tether.min.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/ckeditor/ckeditor.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/bootstrap-validator/dist/validator.min.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/dropzone/dist/dropzone.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/bootstrap/js/dist/util.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/bootstrap/js/dist/tab.js"></script>
    <script src="<?php echo base_url();?>style/cms/js/main.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/dragula.js/dist/dragula.min.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/bootstrap/js/dist/modal.js"></script>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>style/cms/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url();?>style/tinymce/tinymce.min.js"></script>

    <script src="<?php echo base_url();?>style/cms/bower_components/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/bootstrap/js/dist/tooltip.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/slick-carousel/slick/slick.min.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/bootstrap/js/dist/alert.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/bootstrap/js/dist/button.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/bootstrap/js/dist/carousel.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/bootstrap/js/dist/collapse.js"></script>
    <script src="<?php echo base_url();?>style/cms/bower_components/bootstrap/js/dist/dropdown.js"></script>
    <script src="<?php echo base_url();?>assets/js/ajax-form-submission.js"></script>
    <script src='<?php echo base_url();?>style/fullcalendar/js/fullcalendar.min.js'></script>
    <script src="<?php echo base_url();?>style/olapp/js/jquery.appear.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/jquery.matchHeight.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/svgxuse.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/Headroom.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/velocity.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/ScrollMagic.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/jquery.waypoints.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/jquery.countTo.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/material.min.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/bootstrap-select.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/smooth-scroll.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/selectize.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/swiper.jquery.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/moment.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/isotope.pkgd.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/circle-progress.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/loader.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/jquery.magnific-popup.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/sticky-sidebar.js"></script>
    <script src="<?php echo base_url();?>style/olapp/js/base-init.js"></script>
    <script defer src="<?php echo base_url();?>style/olapp/fonts/fontawesome-all.js"></script>
    <script src="<?php echo base_url();?>style/olapp/Bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script src="<?php echo base_url();?>style/js/sweetalert.min.js"></script>

    <!-- FROALA SCRIPTS-->

    <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
    <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/froala_editor.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/align.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/char_counter.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/code_beautifier.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/code_view.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/colors.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/draggable.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/emoticons.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/entities.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/file.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/font_size.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/font_family.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/fullscreen.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/image.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/image_manager.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/line_breaker.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/inline_style.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/link.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/lists.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/paragraph_format.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/paragraph_style.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/quick_insert.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/quote.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/table.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/save.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/url.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/video.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/help.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/print.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/third_party/spell_checker.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/special_characters.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/plugins/word_paste.min.js"></script>
    <script src="<?php echo base_url();?>style/froala_node_modules/@wiris/mathtype-froala3/wiris.js"></script>

    <!-- Include TUI JS. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.6.7/fabric.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/tui-code-snippet@1.4.0/dist/tui-code-snippet.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/tui-image-editor@3.2.2/dist/tui-image-editor.min.js"></script>

    <!-- Include TUI plugin. -->
    <script type="text/javascript" src="<?php echo base_url();?>style/froala_js/js/third_party/image_tui.min.js"></script>

   <!-- FROALA SCRIPTS -->

   <script src="https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image"></script>