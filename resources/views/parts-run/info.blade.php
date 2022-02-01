@extends('layouts.app')
@section('content')
    <div class="build-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h4>Parts Run Information</h4>
                </div>

                <div class="col-12">
                    <p>
                        Part Runs are talked about a lot in the Droid Building Community and we felt it was a good idea to list some of the regular questions
                        and requested information about parts runs. Currently this information only applies to <a href="https://www.astromech.net"><u>Astromech.net</u></a> tailored to Astromech Parts Runs however we
                        are looking to expand this to other droids. 
                    </p>

                    <div id="accordion">
                        <div class="build-section d-block">
                            <div class="db-card">
                                <div class="db-card-header" id="headingOne">
                                    <h5 class="db-card-title">
                                    <button class="btn btn-accordion" data-toggle="collapse" data-target="#parts-run-1" aria-expanded="false" aria-controls="parts-run-1">
                                        <strong>What are part runs?</strong>
                                    </button>
                                    </h5>
                                </div>
                            
                                <div id="parts-run-1" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="db-card-body">
                                    <p>A parts run is run via Astromech.net and allows people to purchase parts for their Astromech droid.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="db-card">
                                <div class="db-card-header" id="headingTwo">
                                    <h5 class="db-card-title">
                                    <button class="btn btn-accordion" data-toggle="collapse" data-target="#parts-run-2" aria-expanded="false" aria-controls="parts-run-2">
                                        <strong>Why do we have them?</strong>
                                    </button>
                                    </h5>
                                </div>
                            
                                <div id="parts-run-2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="db-card-body">
                                        <p>
                                            Without parts runs all parts would be scratch built, or 3D printed and assembled.  While this is valid for some parts others such as the lights would be problematic to build one off electronics all the time, so is easier to do a run of 10 kits then sell to builders who need them.  Also economies of scale allow the price to be reduced as more kits are made.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="db-card">
                                <div class="db-card-header" id="headingThree">
                                    <h5 class="db-card-title">
                                    <button class="btn btn-accordion" data-toggle="collapse" data-target="#parts-run-3" aria-expanded="false" aria-controls="parts-run-3">
                                        <strong>What is BC Approved?</strong>
                                    </button>
                                    </h5>
                                </div>
                            
                                <div id="parts-run-3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="db-card-body">
                                        <p>
                                            When a part is BC approved it means it will fit with any other BC approved part, or require minimum effort for them to fit.  A small caveat is there is the legacy CSL spec and newer CSR spec so buyers need to make sure they purchase the right parts as some CSR and CSL parts are not interchangeable.
                                            When BC parts are purchased via the forum it is audited and allows us to see when people signed up.  Then once the parts have been produced the payment can be made and the parts shipped.  This is important as the seller has the initial outlay of the costs, then the parts ship when available rather than taking money up front and then shipping months later.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="db-card">
                                <div class="db-card-header" id="headingFour">
                                    <h5 class="db-card-title">
                                    <button class="btn btn-accordion" data-toggle="collapse" data-target="#parts-run-4" aria-expanded="false" aria-controls="parts-run-4">
                                        <strong>What is the difference between buying a BC Approved Part VS buying from a Facebook Group or eBay?</strong>
                                    </button>
                                    </h5>
                                </div>
                            
                                <div id="parts-run-4" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                    <div class="db-card-body">
                                        <p>
                                            Buying part via the forum means you are getting good parts, even via the junkyard section. On Facebook or eBay you have no idea what you are purchasing, the parts may seem cheap, but they are cheap for a reason as they are potentially badly made, made from cheap materials and made for profit rather than being made to build a decent droid.
                                            You can always read the horror stories on Astromech.net if you have any doubt.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="db-card">
                                <div class="db-card-header" id="headingFive">
                                    <h5 class="db-card-title">
                                    <button class="btn btn-accordion" data-toggle="collapse" data-target="#parts-run-5" aria-expanded="false" aria-controls="parts-run-5">
                                        <strong>What are the rules for supplying a parts run?</strong>
                                    </button>
                                    </h5>
                                </div>
                            
                                <div id="parts-run-5" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                                    <div class="db-card-body">
                                        <p>
                                            The main rules are not taking money up front and keeping people updated and having a sign up list.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="db-card">
                                <div class="db-card-header" id="headingSix">
                                    <h5 class="db-card-title">
                                    <button class="btn btn-accordion" data-toggle="collapse" data-target="#parts-run-6" aria-expanded="false" aria-controls="parts-run-6">
                                        <strong>I would like to do a parts run or a droid piece. How should I go about getting it approved?</strong>
                                    </button>
                                    </h5>
                                </div>
                            
                                <div id="parts-run-6" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
                                    <div class="db-card-body">
                                        <p>
                                            The first step is to fill in the following form on Astromech.net to say you are interested in doing a parts run.
                                            <a href="https://astromech.net/forums/forms.php?do=form&fid=1"><u>https://astromech.net/forums/forms.php?do=form&fid=1</u></a>
                                            Following that one of the BC will be in touch regarding the run. Depending on what is being made it could be a limited run of an agreed amount of parts or a continual run making parts on demand.  Due to the run numbers being sometimes unknown a parts interest thread can be created once the form is submitted, this helps people not making 100 parts and only being able to sell 10 so is in the sellers interest.  As it allows a rough number of interested people this can be used to get a cost for the parts as the unit cost of 10 parts will be typically be more expensive than the unit cost of 20 parts.
                                            Once the run is approves then a sales thread can be created.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
