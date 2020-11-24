@extends('admin.master')
@section('body')
    <style>
        .table{
            margin-bottom: 10px !important;
        }
        .table th,td{
            border: 1px solid #ccc;
            padding: 3px 10px !important;
        }
        .invoice p{
            margin-bottom: 12px !important;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <section class="invoice">
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-4">
                            </h2>
                        </div>
                        <div class="col-3">
                            <h5 class="text-center">PROFORMA INVOICE</h5>
                        </div>
                        
                    </div>
                    <div class="row invoice-info">
                        <div class="col-6">From
                            <address><strong style="color: #2f4984;">GCL International BD</strong><br>House 75 | Road No 19 | Sector 11 Uttara | Dhaka 1230 | Bangladesh
                                <br>M: +8801712 759149
                                <br>E: bangladesh@gcl-intl.com
                            </address>
                        </div>
                        <div class="col-6">To
                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <h5>Certification Fee</h5>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                               
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 table-responsive">
                            <h5>Other expenses</h5>
                            <table class="table table-striped">
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th>Label</th>--}}
                                    {{--<th>Description</th>--}}
                                    {{--<th>Amount</th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}
                                <tbody>
                               
                                </tbody>
                            </table>
                            <p>Note: In case of requiring any Sub-con inspection (apart from what stated above) client will be charged additionally
                            </p>
                        </div>
                        <div class="col-12 table-responsive">
                            <h5>Payment Details</h5>
                            <table class="table table-striped">
                               
                                <tbody>
                                
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 table-responsive">
                            <h5>Post audit activities</h5>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Post audit activities</th>
                                    <th>Particulars</th>
                                    <th>Fees</th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p><span style="font-weight: bold;">Payment Terms: </span> </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            
                        </div>
                        <div class="col-md-6 d-print-none text-right">
                            <input class="btn btn-primary" type="button" value="Print" onclick="window.print()" />
                            {{--<a class="btn btn-primary" href="javascript:window.print();" target="_blank"><i class="fa fa-print"></i> Print</a></div>--}}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

