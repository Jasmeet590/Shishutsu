      @extends('layout.app')  


     @section('content') 


                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title font-weight-bold"> CREATE GST BILL </h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title text-uppercase">Invoice Basic Info</h4>
                                    <hr>
                                    <form action="{{ route('create-gst-bill') }}" method="post">
                                        @csrf
                                        @include('include.alert')
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label>Party</label>
                                                    <input type="text" class="form-control border-bottom" id="partySearch" placeholder="Search party name" autocomplete="off">
                                                    <input type="hidden" name="party_id" id="partyId" value="">
                                                    <div id="partySuggestions" class="list-group" style="position:absolute;z-index:10;width:calc(100% - 30px);display:none;"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label>Invoice Date</label>
                                                    <input type="date" name="invoice_date" class="form-control border-bottom"
                                                        id="validationCustom02" placeholder="Enter Phone/Mobile number">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label>Invoice Number</label>
                                                    <input type="text" name="invoice_number" class="form-control border-bottom"
                                                        id="validationCustom02" placeholder="Enter Phone/Mobile number">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="header-title text-uppercase">Item Details</h4>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8 border p-1 text-center">
                                                <b>DESCRIPTIONS</b>
                                            </div>
                                            <div class="col-md-4 border p-1 text-center">
                                                <b>TOTAL AMOUNT</b>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-8 border p-2">
                                                <input class="form-control" name="item_description" />
                                            </div>
                                            <div class="col-md-4 border p-2">
                                                <input class="form-control" type="text" name="total_amount" id="totalAmountInput" oninput="calculateNetAmount()">
                                            </div>
                                        </div>

                                        <div class="row mt-0">
                                            <div class="col-md-3">
                                                <label>CGST (%)</label>
                                                <input type="text" name="cgst_rate" class="form-control border-bottom" placeholder="CGST Rate" id="cgst" oninput="calculateNetAmount()">
                                                <span class="float-right gststyle" id="cgstDisplay">0</span>
                                                <input type="hidden" id="cgstAmount" name="cgst_amount" value="0">
                                            </div>

                                            <div class="col-md-3">
                                                <label>SGST (%)</label>
                                                <input type="text" name="sgst_rate" class="form-control border-bottom" placeholder="SGST Rate" id="sgst" oninput="calculateNetAmount()">
                                                <span class="float-right gststyle" id="sgstDisplay">0</span>
                                                <input type="hidden" id="sgstAmount" name="sgst_amount" value="0">
                                            </div>

                                            <div class="col-md-3">
                                                <label>IGST (%)</label>
                                                <input type="text" name="igst_rate" class="form-control border-bottom" placeholder="IGST Rate" id="igst" oninput="calculateNetAmount()">
                                                <span class="float-right gststyle" id="igstDisplay">0</span>
                                                <input type="hidden" id="igstAmount" name="igst_amount" value="0">
                                            </div>

                                            <div class="col-md-3">
                                                <ul style="list-style: none;float: right;">
                                                    <li>
                                                        <b>Total Amount:</b> ₹ <span type="text"
                                                            id="totalAmountDisplay">0</span>
                                                    </li>
                                                    <li>
                                                        <b>Tax:</b> ₹ <span type="text" id="taxDisplay">0</span>
                                                        <input type="hidden" value="0" name="tax_amount" id="taxAmount">
                                                    </li>
                                                    <li>
                                                        <b>Net Amount:</b> ₹ <span type="text"
                                                            id="netAmountDisplay">0</span>
                                                        <input type="hidden" value="0" name="net_amount" id="netAmount">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control border-bottom"
                                                        id="validationCustom05" placeholder="Declaration">
                                                </div>

                                                <a href="printGST_bill.html">
                                                    <button type="submit"
                                                        class="btn btn-primary float-right mb-2">SUBMIT</button>
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

        <script>
            const partySuggestions = document.getElementById('partySuggestions');
            const partySearch = document.getElementById('partySearch');
            const partyId = document.getElementById('partyId');
            const parties = @json($parties->map(function ($party) { return ['id' => $party->id, 'name' => $party->full_name]; }));

            partySearch.addEventListener('input', function () {
                const query = this.value.toLowerCase().trim();
                partySuggestions.innerHTML = '';

                if (!query) {
                    partySuggestions.style.display = 'none';
                    partyId.value = '';
                    return;
                }

                const matches = parties.filter(function (party) {
                    return party.name.toLowerCase().includes(query);
                }).slice(0, 8);

                if (!matches.length) {
                    partySuggestions.style.display = 'none';
                    partyId.value = '';
                    return;
                }

                partySuggestions.style.display = 'block';
                matches.forEach(function (party) {
                    const item = document.createElement('button');
                    item.type = 'button';
                    item.className = 'list-group-item list-group-item-action';
                    item.textContent = party.name;
                    item.addEventListener('click', function () {
                        partySearch.value = party.name;
                        partyId.value = party.id;
                        partySuggestions.style.display = 'none';
                    });
                    partySuggestions.appendChild(item);
                });
            });

            document.addEventListener('click', function (event) {
                if (!partySuggestions.contains(event.target) && event.target !== partySearch) {
                    partySuggestions.style.display = 'none';
                }
            });
        </script>

        @endsection