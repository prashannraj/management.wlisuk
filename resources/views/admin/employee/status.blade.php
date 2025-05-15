<!-- EDIT MODAL SECTION -->
<div id="editStatus" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Status</h4>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="table-responsive">      
                            <table class="table table-striped table-inverse enquiry-activities">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Status</th>
                                        <th>Follow Up</th>
                                        <!-- <th>Note</th> -->
                                        <th>Created_by</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div id="status-modification-form" class="card mt-2">
                            <div class="card-body">
                                    <div id="errorDiv"></div>
                                    <input type="hidden" id="activity-type" value=""/>
                                    <input type="hidden" id="activity-id" value=""/>
                                    <input type="hidden" id="enquiry-id" value=""/>
                                    <div class="form-group">
                                            <label for="" id="form-heading"></label>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-3">
                                            <label for="" class="form-label">Status:</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control statusModification" name="status_modification">
                                                <option value="">Please Select</option>
                                                <option value="2">Follow Up</option> 
                                                <option value="3">Processed</option>
                                                <option value="4">Closed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-3">
                                            <label for="" class="form-label">Note:</label>
                                        </div>
                                        <div class="col-9">
                                            <textarea class="form-control" name="status_note"></textarea>
                                        </div>
                                    </div>
                                    <div class="follow-up-section">
                                            <div class="form-group">
                                                    <label id="form-heading">Follow up</label>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-3">
                                                    <label for="" class="form-label">Date:</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" class="form-control follow-up-date" name="followUpDate"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-3">
                                                    <label for="" class="form-label">Note:</label>
                                                </div>
                                                <div class="col-9">
                                                    <textarea class="form-control" name="followUpNote"></textarea>
                                                </div>
                                            </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="updateStatus">Update Status</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
        </div>
    </div>
</div>
<!-- END OF THE EDIT MODAL SECTION -->