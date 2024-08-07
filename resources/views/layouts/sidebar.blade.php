<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>
            @if (Auth()->user()->role_id == 1)
            <li><a href="{{ route('admin.dashboard') }}" aria-expanded="false"><i
                class="icon icon-chart-bar-33"></i><span class="nav-text">Dashboard</span></a>
            </li>
            <li><a href="{{ route('admin.daftar-masyarakat') }}" aria-expanded="false"><i
                class="icon icon-single-04"></i><span class="nav-text">Daftar Masyarakat</span></a>
            </li>
            <li class="nav-label">Arsip Koran</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-app-store"></i><span class="nav-text">Arsip Koran</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.koran') }}">Olah Arsip Koran</a></li>
                </ul>
            </li>
            <li class="nav-label">Arsip Prestasi</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-app-store"></i><span class="nav-text">Arsip Prestasi</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.arpres') }}">Olah Arsip Prestasi</a></li>
                </ul>
            </li>
            @endif
            @if (Auth()->user()->role_id == 2)
            <li><a href="{{ route('masyarakat.dashboard') }}" aria-expanded="false"><i
                class="icon icon-chart-bar-33"></i><span class="nav-text">Dashboard</span></a>
            </li>
            <li class="nav-label">Olah Arsip</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-app-store"></i><span class="nav-text">Arsip</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('masyarakat.arpen') }}">Arsip Pendidikan</a></li>
                    <li><a href="{{ route('masyarakat.arkep') }}">Arsip Kependudukan</a></li>
                    <li><a href="{{ route('masyarakat.arkes') }}">Arsip Kesehatan</a></li>
                    <li><a href="{{ route('masyarakat.arpri') }}">Arsip Pribadi</a></li>
                </ul>
            </li>
            <li class="nav-label">Arsip Koran</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-app-store"></i><span class="nav-text">Pengajuan Arsip Koran</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('masyarakat.koran-pengajuan') }}">Olah Arsip Koran</a></li>
                </ul>
            </li>
            <li class="nav-label">Arsip Prestasi</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-app-store"></i><span class="nav-text">Arsip Prestasi</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('masyarakat.arpres') }}">Olah Arsip Prestasi</a></li>
                </ul>
            </li>
            @endif
            {{-- <li class="nav-label">Components</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-world-2"></i><span class="nav-text">Bootstrap</span></a>
                <ul aria-expanded="false">
                    <li><a href="./ui-accordion.html">Accordion</a></li>
                    <li><a href="./ui-alert.html">Alert</a></li>
                    <li><a href="./ui-badge.html">Badge</a></li>
                    <li><a href="./ui-button.html">Button</a></li>
                    <li><a href="./ui-modal.html">Modal</a></li>
                    <li><a href="./ui-button-group.html">Button Group</a></li>
                    <li><a href="./ui-list-group.html">List Group</a></li>
                    <li><a href="./ui-media-object.html">Media Object</a></li>
                    <li><a href="./ui-card.html">Cards</a></li>
                    <li><a href="./ui-carousel.html">Carousel</a></li>
                    <li><a href="./ui-dropdown.html">Dropdown</a></li>
                    <li><a href="./ui-popover.html">Popover</a></li>
                    <li><a href="./ui-progressbar.html">Progressbar</a></li>
                    <li><a href="./ui-tab.html">Tab</a></li>
                    <li><a href="./ui-typography.html">Typography</a></li>
                    <li><a href="./ui-pagination.html">Pagination</a></li>
                    <li><a href="./ui-grid.html">Grid</a></li>

                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-plug"></i><span class="nav-text">Plugins</span></a>
                <ul aria-expanded="false">
                    <li><a href="./uc-select2.html">Select 2</a></li>
                    <li><a href="./uc-nestable.html">Nestedable</a></li>
                    <li><a href="./uc-noui-slider.html">Noui Slider</a></li>
                    <li><a href="./uc-sweetalert.html">Sweet Alert</a></li>
                    <li><a href="./uc-toastr.html">Toastr</a></li>
                    <li><a href="./map-jqvmap.html">Jqv Map</a></li>
                </ul>
            </li>
            <li><a href="widget-basic.html" aria-expanded="false"><i class="icon icon-globe-2"></i><span
                        class="nav-text">Widget</span></a></li>
            <li class="nav-label">Forms</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-form"></i><span class="nav-text">Forms</span></a>
                <ul aria-expanded="false">
                    <li><a href="./form-element.html">Form Elements</a></li>
                    <li><a href="./form-wizard.html">Wizard</a></li>
                    <li><a href="./form-editor-summernote.html">Summernote</a></li>
                    <li><a href="form-pickers.html">Pickers</a></li>
                    <li><a href="form-validation-jquery.html">Jquery Validate</a></li>
                </ul>
            </li>
            <li class="nav-label">Table</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-layout-25"></i><span class="nav-text">Table</span></a>
                <ul aria-expanded="false">
                    <li><a href="table-bootstrap-basic.html">Bootstrap</a></li>
                    <li><a href="table-datatable-basic.html">Datatable</a></li>
                </ul>
            </li>

            <li class="nav-label">Extra</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-single-copy-06"></i><span class="nav-text">Pages</span></a>
                <ul aria-expanded="false">
                    <li><a href="./page-register.html">Register</a></li>
                    <li><a href="./page-login.html">Login</a></li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Error</a>
                        <ul aria-expanded="false">
                            <li><a href="./page-error-400.html">Error 400</a></li>
                            <li><a href="./page-error-403.html">Error 403</a></li>
                            <li><a href="./page-error-404.html">Error 404</a></li>
                            <li><a href="./page-error-500.html">Error 500</a></li>
                            <li><a href="./page-error-503.html">Error 503</a></li>
                        </ul>
                    </li>
                    <li><a href="./page-lock-screen.html">Lock Screen</a></li>
                </ul>
            </li> --}}
        </ul>
    </div>


</div>