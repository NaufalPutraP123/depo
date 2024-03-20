<div class="clearfix"></div>
<div id="home">
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-7 mx-auto">
                <?php 
                    if(!empty($this->session->flashdata('success'))){  
                       echo alert_success($this->session->flashdata('success')); 
                    }
                    if(!empty($this->session->flashdata('failed'))){ 
                       echo alert_failed($this->session->flashdata('failed'));
                    }
                ?>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Import File</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('menu/proses_import');?>" method="post"
                            enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="exampleInputFile">File Upload (Excel)</label>
                                <input type="file" name="berkas_excel"
                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                    class="form-control" id="exampleInputFile">
                            </div>
                            <button type="submit" class="btn btn-primary btn-md">Save</button>
                            <a href="<?= base_url().'assets/file/format_import.xlsx';?>" class="btn btn-success btn-md">
                                <i class="fa fa-download mr-1"></i> Format File Excel
                            </a>
                            <a href="<?= base_url('menu');?>" class="btn btn-danger btn-md">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>