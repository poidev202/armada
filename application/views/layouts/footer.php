
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php 
                $tahunDeveloper = date("Y") > "2018" ? "2018 - ".date('Y') : "2018";
             ?>
            <footer class="footer">
                Copy Right © <?php echo $tahunDeveloper; ?> <a href="https://poi.co.id" target="_blank">PT. Prima Optimasi Indonesia</a> 

                <div class="pull-right">
                    Developer by <a href="https://www.linkedin.com/in/musafii-fii-14a450150" target="_blank">Musafi'i</a>
                </div>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo base_url();?>assets/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo base_url();?>assets/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?php echo base_url();?>assets/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?php echo base_url();?>assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="<?php echo base_url();?>assets/js/custom.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.PrintArea.js" type="text/JavaScript"></script>
    <script src="<?php echo base_url();?>assets/js/excelexportjs.js" type="text/JavaScript"></script>

    <script>
        $(document).ready(function() {
            $(".btn-print").click(function() {
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close
                };
                $("div.printableArea").printArea(options);
            });
        });
    </script>

    <!-- ============================================================== -->
    <!-- This page plugins -->
    
    <!-- Sweet-Alert  -->
    <script src="<?php echo base_url();?>assets/plugins/sweetalert2/sweetalert2.all.js"></script>

    <!-- jQuery file upload -->
    <script src="<?php echo base_url();?>assets/plugins/dropify/dist/js/dropify.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.dropify').dropify();

            $('.dropify-indo').dropify({
                defaultFile: "/assets/images/default/no_image.jpg",
                messages: {
                    default: 'Drag dan letakkan file di sini atau klik',
                    replace: 'Drag dan drop file atau klik untuk menggantikan',
                    remove: 'Hapus',
                    error: 'Ooops, ada sesuatu yang salah terjadi'
                },
                error: {
                    fileSize: 'Ukuran file terlalu besar ( {{ value }}b max ).',
                    minWidth: 'Lebar gambar terlalu kecil ( {{ value }}}px min ).',
                    maxWidth: 'Lebar gambar terlalu besar ( {{ value }}}px max ).',
                    minHeight: 'Ketinggian gambar terlalu kecil ( {{ value }}}px min ).',
                    maxHeight: 'Ketinggian gambar terlalu besar ( {{ value }}px max ).',
                    imageFormat: 'Format gambar tidak diizinkan hanya ( {{ value }} ).',
                    fileExtension:"File tidak diizinkan, hanya ( {{ value }} ) yang di boleh kan."
                }

            }); 
        });
    </script>


    <script src="<?php echo base_url();?>assets/plugins/moment/moment.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- Clock Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
    <!-- Color Picker Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/jquery-asColorPicker-master/libs/jquery-asColor.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/jquery-asColorPicker-master/libs/jquery-asGradient.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script>
        // MAterial Date picker    
        $('.tanggal').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

        $('.tahun').bootstrapMaterialDatePicker({ format : 'YYYY', year: true, time: false,});

        $('#timepicker').bootstrapMaterialDatePicker({ format : 'HH:mm', time: true, date: false });
        $('#date-format').bootstrapMaterialDatePicker({ format : 'dddd DD MMMM YYYY - HH:mm' });
       
            $('#min-date').bootstrapMaterialDatePicker({ format : 'DD/MM/YYYY HH:mm', minDate : new Date() });
        // Clock pickers
        $('#single-input').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
            'default': 'now'
        });
        $('.clockpicker').clockpicker({
            donetext: 'Done',
        }).find('input').change(function() {
            console.log(this.value);
        });
        $('#check-minutes').click(function(e) {
            // Have to stop propagation here
            e.stopPropagation();
            input.clockpicker('show').clockpicker('toggleView', 'minutes');
        });
        if (/mobile/i.test(navigator.userAgent)) {
            $('input').prop('readOnly', true);
        }
        // Colorpicker
        $(".colorpicker").asColorPicker();
        $(".complex-colorpicker").asColorPicker({
            mode: 'complex'
        });
        $(".gradient-colorpicker").asColorPicker({
            mode: 'gradient'
        });
        // Date Picker
        jQuery('.mydatepicker, #datepicker').datepicker();
        jQuery('#datepicker-autoclose').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        jQuery('.date-range').datepicker({
            toggleActive: true,
            format: 'yyyy-mm-dd',
            autoclose: true,
        });
        jQuery('#datepicker-inline').datepicker({
            todayHighlight: true
        });
        // Daterange picker
        $('.input-daterange-datepicker').daterangepicker({
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-danger',
            cancelClass: 'btn-inverse'
        });
        $('.input-daterange-timepicker').daterangepicker({
            timePicker: true,
            format: 'MM/DD/YYYY h:mm A',
            timePickerIncrement: 30,
            timePicker12Hour: true,
            timePickerSeconds: false,
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-danger',
            cancelClass: 'btn-inverse'
        });
        $('.input-limit-datepicker').daterangepicker({
            format: 'MM/DD/YYYY',
            minDate: '06/01/2015',
            maxDate: '06/30/2015',
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-danger',
            cancelClass: 'btn-inverse',
            dateLimit: {
                days: 6
            }
        });
    </script>

    <!-- select2 version 4 -->
    <!-- <script src="<?php //echo base_url();?>assets/plugins/x-editable/dist/bootstrap-editable/js/bootstrap-editable.js" type="text/javascript"></script> -->
    <!-- <script src="<?php //echo base_url();?>assets/plugins/select2/dist/js/select2.full.min.js" type="text/javascript"></script> -->

    <script src="<?php echo base_url();?>assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

    <!-- select2 version 3 -->
    <!-- <script src="<?php //echo base_url();?>assets/plugins/select2-3.5.4/select2.js" type="text/javascript"></script>

    <script src="<?php //echo base_url();?>assets/plugins/select2-3.5.4/select2_locale_id.js" type="text/javascript"></script> -->
    <script src="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>

    <script type="text/javascript">
            /*$('.select2').css('width','100%').select2({
                allowClear:true
            });*/
        jQuery(document).ready(function() {
            
            
            // For select 2
            $(".select2").select2({
                language: {
                    noResults: function(){
                       return "Data tidak ada.!";
                    }
                },
                escapeMarkup: function (markup) {
                    return markup;
                }
            });

            $('.selectpicker').selectpicker();
        });

        setInterval(()=>{$.post("/auth/logoutAuto",function(json){if(json.status==!0){swal({type:'warning',title:'Session Login Anda Telah Habis.!',showConfirmButton:!1,timer:4500,animation:!1,customClass:'animated swing'});setTimeout(function(){window.location.href="/"},4000)}})},60000);

    </script>
    <?php 
        $uriSeg = $this->uri->segment(1);
        $classMth = $this->router->fetch_class();
     ?>
    <?php if ($uriSeg == "performa" && $classMth == "suratjalan"): ?>
        
    <script type="text/javascript">
        /*Surat jalan / trip => modul baru*/
        $("#btnCheckJadwal").click(function() {
            var valTgl = $("#tgl_hari_jadwal").val();
            var tgl = "";
            var url = "";
            if (valTgl != "") {
                url = "/performa/suratjalan/checkHariPerTanggal/"+valTgl;
            } else {
                // tgl = new Date().toISOString().split('T')[0];
                url = "/performa/suratjalan/checkHariPerTanggal";
            }

            $.post(url,function(res) {
                if (res.status == true) {
                    $("#hariTglTrip").html(res.hari_tgl);
                    $("#trTrip").html(res.data);
                    $("#dataTableTrip").show(500);
                    $("#errorTableTrip").html("");
                    /*ajax search select2*/
                    ajaxSearchSelect2("select[name='nama_armada[]']","Armada","/performa/armadastatus/allArmadaStandByAjax","armada");
                    ajaxSearchSelect2("select[name='supir1[]']","Supir 1","/master/karyawan/getAllSupirAjax/supir1","supir1");
                    ajaxSearchSelect2("select[name='supir2[]']","Supir 2","/master/karyawan/getAllSupirAjax/supir2","supir2");
                    $("#tgl_hari_jadwal").val(res.tanggal);

                    /*for (var i = 1; i <= res.count_data; i++) {
                        console.log(i);
                    }*/
                    /*for (var i = 1; i <= res.count_data; i++) {
                        // alert(i);
                        
                        $("#nama_armada"+i).change(function () {
                            id_val = $("#nama_armada"+i).val();
                            alert(id_val);
                            if (id_val != "") {
                                $.post("/master/armada/getId/"+id_val,function (json) {
                                    if (json.status == true) {
                                        swal({   
                                            title: "Armada Detail",   
                                            html: json.data.no_bk+" Nama = "+json.data.nama,
                                            type: "info",
                                        });
                                    } else {
                                        swal({   
                                            title: "Armada Detail",   
                                            html: json.message,
                                            type: "info",
                                        });
                                    }
                                });     
                            }
                        });
                    }*/

                } else {
                    $("#errorTableTrip").html(res.message);
                    setTimeout(function() {
                         $("#errorTableTrip").html("");
                    },6000);
                    $("#dataTableTrip").hide(700);
                }
            });
        });

        function ajaxSearchSelect2(emt,phol,ur,forRepo) {
            if (forRepo == "armada") {
                formatRepo = formatRepoArmada;
            } else if (forRepo == "supir1") {
                formatRepo = formatRepoSupir1;
            } else if (forRepo == "supir2") {
                formatRepo = formatRepoSupir2;
            }
            $(emt).select2({
                placeholder: '-- Pilih '+phol+'--',
                ajax: {
                    url: ur,
                    type: "post",
                    dataType: 'json',
                    // delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        // console.log(response);
                        return {
                            results: response.data
                        };
                    },
                    cache: true
                },
                language: {
                    noResults: function(){
                       return "Data tidak ada.!";
                    }
                },
                escapeMarkup: function (markup) {
                    return markup;
                },
                templateResult: formatRepo,
            });
        }

        function formatRepoArmada (repo) {
            var markup = "<div class='select2-result-repository clearfix'>" +
                            "<div class='row'>"+
                                "<div class='col-md-4'>"+
                                     "<div class='select2-result-repository__avatar'>"+
                                        "<img src='" + repo.photo + "' class='card-img-top img-responsive' style='height:80px; width:80px;' />"+
                                    "</div>" +
                                "</div>"+
                                "<div class='col-md-8'>"+
                                    "<div class='select2-result-repository__meta'>" +
                                        "<div class='select2-result-repository__title'><b>Armada</b> : " + repo.nama + "</div>"+
                                            "<div class='select2-result-repository__statistics'>" +
                                            "<div class='select2-result-repository__forks'><b>No Plat</b> : " + repo.no_bk + "</div>" +
                                        "</div>" +
                                    "</div>"+
                                "</div>"+
                         "</div>";

            return markup;
        }

        function formatRepoSupir1 (repo) {
            var markup = "<div class='select2-result-repository clearfix'>" +
                            "<div class='row'>"+
                                "<div class='col-md-5'>"+
                                     "<div class='select2-result-repository__avatar'>"+
                                        "<img src='" + repo.foto_karyawan + "' class='card-img-top img-responsive' style='height:80px; width:80px;' />"+
                                    "</div>" +
                                "</div>"+
                                "<div class='col-md-7'>"+
                                    "<div class='select2-result-repository__meta'><small>" +
                                        "<div class='select2-result-repository__title'><b>Nama</b> : " + repo.nama + "</div>"+
                                            "<div class='select2-result-repository__statistics'>" +
                                            "<div class='select2-result-repository__forks'><b>Kode</b> : " + repo.kode + "</div>" +
                                            "<div class='select2-result-repository__forks'><b>Tgl lahir</b> : " + repo.tanggal_lahir_indo + "</div>" +
                                            "<div class='select2-result-repository__forks'><b>Kelamin</b> : " + repo.kelamin + "</div>" +
                                        "</small></div>" +
                                    "</div>"+
                                "</div>"+
                         "</div>";

            return markup;
        }

        function formatRepoSupir2 (repo) {
            var markup = "<div class='select2-result-repository clearfix'>" +
                            "<div class='row'>"+
                                "<div class='col-md-7'>"+
                                    "<small><div class='select2-result-repository__meta'>" +
                                        "<div class='select2-result-repository__title'><b>Nama</b> : " + repo.nama + "</div>"+
                                            "<div class='select2-result-repository__statistics'>" +
                                            "<div class='select2-result-repository__forks'><b>Kode</b> : " + repo.kode + "</div>" +
                                            "<div class='select2-result-repository__forks'><b>Tgl lahir</b> : " + repo.tanggal_lahir_indo + "</div>" +
                                            "<div class='select2-result-repository__forks'><b>Kelamin</b> : " + repo.kelamin + "</div>" +
                                        "</div>" +
                                    "</small></div>"+
                                "</div>"+
                                "<div class='col-md-4'>"+
                                     "<div class='select2-result-repository__avatar'>"+
                                        "<img src='" + repo.foto_karyawan + "' class='card-img-top img-responsive' style='height:80px; width:80px;' />"+
                                    "</div>" +
                                "</div>"+
                         "</div>";

            return markup;
        }

        /*var idArmada;
        $("select[name='nama_armada[]']").change(function () {
            id_val = $("select[name='nama_armada[]']").val();
            if (id_val != "") {
                idArmada = id_val;
                $.post("/master/armada/getId/"+idArmada,function (json) {
                    if (json.status == true) {
                        swal({   
                            title: "Armada Detail",   
                            html: json.data.no_bk,
                            type: "info",
                        });
                    } else {
                        $("#errorNamaArmada").html(json.message);
                    }
                });     
            } else {
                $("#imgArmada").attr("src","/assets/images/default/no_image.jpg");
                $("#imgArmadaPopup").attr("href","/assets/images/default/no_image.jpg");
                $("#no_bk").val("");
                $("#tahun").val("");
            }
        });*/
    </script>

    <?php endif ?>

    <!-- This is data table -->
    <script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js"></script>

    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

    <!-- ============================================================== -->
    <!--sparkline JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- chartist chart -->
    <script src="<?php echo base_url();?>assets/plugins/chartist-js/dist/chartist.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>

    <!--morris JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/raphael/raphael-min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/morrisjs/morris.min.js"></script>
    <!-- Chart JS -->
    <!-- <script src="<?php //echo base_url();?>assets/js/dashboard1.js"></script> -->
    
    <!-- Magnific popup JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>

    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?php echo base_url();?>assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>