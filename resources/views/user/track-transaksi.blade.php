<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css
" />

<div class="modal fade" id="Track{{ $trans->id }}" tabindex="-1" aria-labelledby="TrackLabel{{ $trans->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Added modal-lg to make the modal wider -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TrackLabel{{ $trans->id }}">Tracking Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container px-1 px-md-4 py-5 mx-auto">
                    <div class="card">
                        <div class="row d-flex justify-content-between px-3 top">
                            <div class="d-flex">
                                <h5>ORDER <span class="text-primary font-weight-bold">#{{ $trans->Invoice }}</span></h5>
                            </div>
                            <div class="d-flex flex-column text-sm-right">
                                <p class="mb-0">Payment At <span>{{ $trans->payment_at }}</span></p>
                                <p>Total<span class="m-2 font-weight-bold">Rp
                                        {{ number_format($trans->total, 2, ',', '.') }}</span>
                                </p>
                            </div>
                        </div>
                        <!-- Add class 'active' to progress -->
                        <div class="row d-flex justify-content-center">
                            <div class="col-12">
                                <ul id="progressbar" class="text-center">
                                    <li
                                        class="{{ in_array($trans->status_order, ['waiting', 'order_place', 'on_progress', 'finished']) ? 'active' : '' }} step0">
                                        Waiting</li>
                                    <li
                                        class="{{ in_array($trans->status_order, ['order_place', 'on_progress', 'finished']) ? 'active' : '' }} step0">
                                        Order Placed</li>
                                    <li
                                        class="{{ in_array($trans->status_order, ['on_progress', 'finished']) ? 'active' : '' }} step0">
                                        On Progress</li>
                                    <li class="{{ $trans->status_order === 'finished' ? 'active' : '' }} step0">
                                        Finished</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    .container {
        overflow-x: hidden;
        height: 100%;
        background-repeat: no-repeat;
    }

    .card {
        z-index: 0;
        background-color: #ECEFF1;
        padding-bottom: 20px;
        margin-top: 90px;
        margin-bottom: 90px;
        border-radius: 10px;
    }

    .top {
        padding-top: 40px;
        padding-left: 10% !important;
        padding-right: 10% !important;
    }

    /*Icon progressbar*/
    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        color: #455A64;
        padding-left: 0px;
        margin-top: 30px;
    }

    #progressbar li {
        list-style-type: none;
        font-size: 13px;
        width: 25%;
        float: left;
        position: relative;
        font-weight: 400;
    }

    #progressbar .step0:before {
        font-family: FontAwesome;
        content: "\f10c";
        color: #fff;
    }

    #progressbar li:before {
        width: 40px;
        height: 40px;
        line-height: 45px;
        display: block;
        font-size: 20px;
        background: #C5CAE9;
        border-radius: 50%;
        margin: auto;
        padding: 0px;
    }

    #progressbar li:after {
        content: '';
        width: 100%;
        height: 12px;
        background: #C5CAE9;
        position: absolute;
        left: 0;
        top: 16px;
        z-index: -1;
    }

    #progressbar li.active:before,
    #progressbar li.active:after {
        background: #651FFF;
    }

    #progressbar li.active:before {
        font-family: FontAwesome;
        content: "\f00c";
    }

    #progressbar li:last-child:after {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        position: absolute;
        left: -50%;
    }

    #progressbar li:nth-child(2):after,
    #progressbar li:nth-child(3):after {
        left: -50%;
    }

    #progressbar li:first-child:after {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        position: absolute;
        left: 50%;
    }

    #progressbar li:last-child:after {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    #progressbar li:first-child:after {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }
</style>
