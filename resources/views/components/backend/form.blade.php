@extends('components/back-source')

@section('content')
    <div class="page-content">
        <div class="row margin-b-0">
            <div class="col s12 m12 l12">
                <div class="card no-shadow">
                    <div class="card-content">
                        <span class="card-title">Basic forms</span>
                        <p>
                            Forms are the standard way to receive user inputted data. The transitions and smoothness of these elements are very important because of the inherent user interaction associated with forms.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row margin-b-0">
            <div class="col s12 m12 l6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Input fields</span>
                        <div class="row margin-b-0">
                            <form class="col s12">
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input placeholder="Placeholder" id="first_name" type="text" class="validate">
                                        <label for="first_name" class="active">First Name</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="last_name" type="text" class="validate">
                                        <label for="last_name" class="">Last Name</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input disabled="" value="I am not editable" id="disabled" type="text" class="validate">
                                        <label for="disabled" class="active">Disabled</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="password" type="password" class="validate">
                                        <label for="password" class="">Password</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="email" type="email" class="validate">
                                        <label for="email" class="">Email</label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Select</span>
                        <div class="row margin-b-0">
                            <form class="col s12">
                                <div class="row margin-b-0">
                                    <div class="input-field col s12">
                                        <select>
                                            <option value="" disabled selected>Choose your option</option>
                                            <option value="1">Option 1</option>
                                            <option value="2">Option 2</option>
                                            <option value="3">Option 3</option>
                                        </select>
                                        <label>Materialize Select</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <select multiple>
                                            <option value="" disabled selected>Choose your option</option>
                                            <option value="1">Option 1</option>
                                            <option value="2">Option 2</option>
                                            <option value="3">Option 3</option>
                                        </select>
                                        <label>Materialize Multiple Select</label>
                                    </div>
                                    <div class="input-field col s12 m12">
                                        <select class="icons">
                                            <option value="" disabled selected>Choose your option</option>
                                            <option value="" data-icon="images/avatar-01.png" class="circle">example 1</option>
                                            <option value="" data-icon="images/avatar-01.png" class="circle">example 2</option>
                                            <option value="" data-icon="images/avatar-01.png" class="circle">example 1</option>
                                        </select>
                                        <label>Images in select</label>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Switches</span>
                        <!-- Switch -->
                        <div class="switch margin-b-20">
                            <label>
                                Off
                                <input type="checkbox">
                                <span class="lever"></span>
                                On
                            </label>
                        </div>

                        <!-- Disabled Switch -->
                        <div class="switch">
                            <label>
                                Off
                                <input disabled type="checkbox">
                                <span class="lever"></span>
                                On
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Date Picker</span>
                        <input type="date" class="datepicker">
                    </div>
                </div>
                <div class="card">
                    <div class="card-content clearfix">
                        <span class="card-title">Autocomplete</span>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">textsms</i>
                            <input type="text" id="autocomplete-input" class="autocomplete">
                            <label for="autocomplete-input">Autocomplete</label>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content clearfix">
                        <span class="card-title">HTML5 Range</span>
                        <form action="form-basic.html#">
                            <p class="range-field">
                                <input type="range" id="test5" min="0" max="100" />
                            </p>
                        </form>

                    </div>
                </div>
            </div>
            <div class="col s12 m12 l6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Icon Prefixes</span>
                        <div class="row margin-b-0">
                            <form class="col s12">
                                <div class="row margin-b-0">
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">account_circle</i>
                                        <input id="icon_prefix" type="text" class="validate">
                                        <label for="icon_prefix">First Name</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">phone</i>
                                        <input id="icon_telephone" type="tel" class="validate">
                                        <label for="icon_telephone">Telephone</label>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Custom Error or Success Messages</span>
                        <div class="row margin-b-0">
                            <form class="col s12">
                                <div class="row margin-b-0">
                                    <div class="input-field col s12">
                                        <input id="email1" type="email" class="validate">
                                        <label for="email1" data-error="wrong" data-success="right">Email</label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Textarea</span>
                        <div class="row margin-b-0">
                            <form class="col s12">
                                <div class="row margin-b-0">
                                    <div class="input-field col s12">
                                        <textarea id="textarea1" class="materialize-textarea"></textarea>
                                        <label for="textarea1">Textarea</label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Radio Buttons</span>
                        <div class="row margin-b-0">
                            <form action="form-basic.html#">
                                <p>
                                    <input name="group1" type="radio" id="test1" />
                                    <label for="test1">Red</label>
                                </p>
                                <p>
                                    <input name="group1" type="radio" id="test2" />
                                    <label for="test2">Yellow</label>
                                </p>
                                <p>
                                    <input class="with-gap" name="group1" type="radio" id="test3"  />
                                    <label for="test3">Green</label>
                                </p>
                                <p>
                                    <input name="group1" type="radio" id="test4" disabled="disabled" />
                                    <label for="test4">Brown</label>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Checkboxes</span>
                        <div class="row margin-b-0">
                            <form action="form-basic.html#">
                                <p>
                                    <input type="checkbox" id="test5" />
                                    <label for="test5">Red</label>
                                </p>
                                <p>
                                    <input type="checkbox" id="test6" checked="checked" />
                                    <label for="test6">Yellow</label>
                                </p>
                                <p>
                                    <input type="checkbox" class="filled-in" id="filled-in-box" checked="checked" />
                                    <label for="filled-in-box">Filled in</label>
                                </p>
                                <p>
                                    <input type="checkbox" id="indeterminate-checkbox" />
                                    <label for="indeterminate-checkbox">Indeterminate Style</label>
                                </p>
                                <p>
                                    <input type="checkbox" id="test7" checked="checked" disabled="disabled" />
                                    <label for="test7">Green</label>
                                </p>
                                <p>
                                    <input type="checkbox" id="test8" disabled="disabled" />
                                    <label for="test8">Brown</label>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Character Counter</span>
                        <div class="row margin-b-0">
                            <form class="col s12">
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="input_text" type="text" length="10">
                                        <label for="input_text">Input text</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <textarea id="textarea1" class="materialize-textarea" length="120"></textarea>
                                        <label for="textarea1">Textarea</label>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection