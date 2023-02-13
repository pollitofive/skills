/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Version: 2.2.0
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Main Js File
*/

(function () {
    ("use strict");

    /**
     *  global variables
     */
    var navbarMenuHTML = document.querySelector(".navbar-menu").innerHTML;
    var horizontalMenuSplit = 7; // after this number all horizontal menus will be moved in More menu options


    //  Search menu dropdown on Topbar
    function elementInViewport(el) {
        if (el) {
            var top = el.offsetTop;
            var left = el.offsetLeft;
            var width = el.offsetWidth;
            var height = el.offsetHeight;

            if (el.offsetParent) {
                while (el.offsetParent) {
                    el = el.offsetParent;
                    top += el.offsetTop;
                    left += el.offsetLeft;
                }
            }
            return (
                top >= window.pageYOffset &&
                left >= window.pageXOffset &&
                top + height <= window.pageYOffset + window.innerHeight &&
                left + width <= window.pageXOffset + window.innerWidth
            );
        }
    }

    function isLoadBodyElement() {
        var verticalOverlay = document.getElementsByClassName("vertical-overlay");
        if (verticalOverlay) {
            Array.from(verticalOverlay).forEach(function (element) {
                element.addEventListener("click", function () {
                    document.body.classList.remove("vertical-sidebar-enable");
                    if (sessionStorage.getItem("data-layout") == "twocolumn")
                        document.body.classList.add("twocolumn-panel");
                    else
                        document.documentElement.setAttribute("data-sidebar-size", sessionStorage.getItem("data-sidebar-size"));
                });
            });
        }
    }

    function windowResizeHover() {
        feather.replace();
        var windowSize = document.documentElement.clientWidth;
        if (windowSize < 1025 && windowSize > 767) {
            document.body.classList.remove("twocolumn-panel");
            if (sessionStorage.getItem("data-layout") == "twocolumn") {
                document.documentElement.setAttribute("data-layout", "twocolumn");
                if (document.getElementById("customizer-layout03")) {
                    document.getElementById("customizer-layout03").click();
                }
                initTwoColumnActiveMenu();
            }
            if (sessionStorage.getItem("data-layout") == "vertical") {
                document.documentElement.setAttribute("data-sidebar-size", "sm");
            }
            if(document.querySelector(".hamburger-icon")){
                document.querySelector(".hamburger-icon").classList.add("open");
            }
        } else if (windowSize >= 1025) {
            document.body.classList.remove("twocolumn-panel");
            if (sessionStorage.getItem("data-layout") == "twocolumn") {
                document.documentElement.setAttribute("data-layout", "twocolumn");
                if (document.getElementById("customizer-layout03")) {
                    document.getElementById("customizer-layout03").click();
                }
                initTwoColumnActiveMenu();
            }
            if (sessionStorage.getItem("data-layout") == "vertical") {
                document.documentElement.setAttribute(
                    "data-sidebar-size",
                    sessionStorage.getItem("data-sidebar-size")
                );
            }
            if(document.querySelector(".hamburger-icon")){
                document.querySelector(".hamburger-icon").classList.remove("open");
            }
        } else if (windowSize <= 767) {
            document.body.classList.remove("vertical-sidebar-enable");
            document.body.classList.add("twocolumn-panel");
            if (sessionStorage.getItem("data-layout") == "twocolumn") {
                document.documentElement.setAttribute("data-layout", "vertical");
                hideShowLayoutOptions("vertical");
            }
            if (sessionStorage.getItem("data-layout") != "horizontal") {
                document.documentElement.setAttribute("data-sidebar-size", "lg");
            }
            if(document.querySelector(".hamburger-icon")){
                document.querySelector(".hamburger-icon").classList.add("open");
            }
        }

        var isElement = document.querySelectorAll("#navbar-nav > li.nav-item");
        Array.from(isElement).forEach(function (item) {
            item.addEventListener("click", menuItem.bind(this), false);
            item.addEventListener("mouseover", menuItem.bind(this), false);
        });
    }

    function menuItem(e) {
        if (e.target && e.target.matches("a.nav-link span")) {
            if (elementInViewport(e.target.parentElement.nextElementSibling) == false) {
                e.target.parentElement.nextElementSibling.classList.add("dropdown-custom-right");
                e.target.parentElement.parentElement.parentElement.parentElement.classList.add("dropdown-custom-right");
                var eleChild = e.target.parentElement.nextElementSibling;
                Array.from(eleChild.querySelectorAll(".menu-dropdown")).forEach(function (item) {
                    item.classList.add("dropdown-custom-right");
                });
            } else if (elementInViewport(e.target.parentElement.nextElementSibling) == true) {
                if (window.innerWidth >= 1848) {
                    var elements = document.getElementsByClassName("dropdown-custom-right");
                    while (elements.length > 0) {
                        elements[0].classList.remove("dropdown-custom-right");
                    }
                }
            }
        }

        if (e.target && e.target.matches("a.nav-link")) {
            if (elementInViewport(e.target.nextElementSibling) == false) {
                e.target.nextElementSibling.classList.add("dropdown-custom-right");
                e.target.parentElement.parentElement.parentElement.classList.add("dropdown-custom-right");
                var eleChild = e.target.nextElementSibling;
                Array.from(eleChild.querySelectorAll(".menu-dropdown")).forEach(function (item) {
                    item.classList.add("dropdown-custom-right");
                });
            } else if (elementInViewport(e.target.nextElementSibling) == true) {
                if (window.innerWidth >= 1848) {
                    var elements = document.getElementsByClassName("dropdown-custom-right");
                    while (elements.length > 0) {
                        elements[0].classList.remove("dropdown-custom-right");
                    }
                }
            }
        }
    }

    function toggleHamburgerMenu() {
        var windowSize = document.documentElement.clientWidth;

        if (windowSize > 767)
            document.querySelector(".hamburger-icon").classList.toggle("open");

        //For collapse horizontal menu
        if (document.documentElement.getAttribute("data-layout") === "horizontal") {
            document.body.classList.contains("menu") ? document.body.classList.remove("menu") : document.body.classList.add("menu");
        }

        //For collapse vertical menu
        if (document.documentElement.getAttribute("data-layout") === "vertical") {
            if (windowSize < 1025 && windowSize > 767) {
                document.body.classList.remove("vertical-sidebar-enable");
                document.documentElement.getAttribute("data-sidebar-size") == "sm" ?
                    document.documentElement.setAttribute("data-sidebar-size", "") :
                    document.documentElement.setAttribute("data-sidebar-size", "sm");
            } else if (windowSize > 1025) {
                document.body.classList.remove("vertical-sidebar-enable");
                document.documentElement.getAttribute("data-sidebar-size") == "lg" ?
                    document.documentElement.setAttribute("data-sidebar-size", "sm") :
                    document.documentElement.setAttribute("data-sidebar-size", "lg");
            } else if (windowSize <= 767) {
                document.body.classList.add("vertical-sidebar-enable");
                document.documentElement.setAttribute("data-sidebar-size", "lg");
            }
        }

        //Two column menu
        if (document.documentElement.getAttribute("data-layout") == "twocolumn") {
            document.body.classList.contains("twocolumn-panel") ?
                document.body.classList.remove("twocolumn-panel") :
                document.body.classList.add("twocolumn-panel");
        }
    }

    function windowLoadContent() {
        // Demo show code
        document.addEventListener("DOMContentLoaded", function () {
            var checkbox = document.getElementsByClassName("code-switcher");
            Array.from(checkbox).forEach(function (check) {
                check.addEventListener("change", function () {
                    var card = check.closest(".card");
                    var preview = card.querySelector(".live-preview");
                    var code = card.querySelector(".code-view");

                    if (check.checked) {
                        preview.classList.add("d-none");
                        code.classList.remove("d-none");
                    } else {
                        preview.classList.remove("d-none");
                        code.classList.add("d-none");
                    }
                });
            });
            feather.replace();
        });

        window.addEventListener("resize", windowResizeHover);
        windowResizeHover();

        Waves.init();

        document.addEventListener("scroll", function () {
            windowScroll();
        });

        window.addEventListener("load", function () {
            var isTwoColumn = document.documentElement.getAttribute("data-layout");
            if (isTwoColumn == "twocolumn") {
                initTwoColumnActiveMenu();
            } else {
                initActiveMenu();
            }
            isLoadBodyElement();
        });
        if(document.getElementById("topnav-hamburger-icon")){
            document.getElementById("topnav-hamburger-icon").addEventListener("click", toggleHamburgerMenu);
        }
        var isValues = sessionStorage.getItem("defaultAttribute");
        var defaultValues = JSON.parse(isValues);
        var windowSize = document.documentElement.clientWidth;

        if (defaultValues["data-layout"] == "twocolumn" && windowSize < 767) {
            Array.from(document.getElementById("two-column-menu").querySelectorAll("li")).forEach(function (item) {
                item.addEventListener("click", function (e) {
                    document.body.classList.remove("twocolumn-panel");
                });
            });
        }
    }

    // page topbar class added
    function windowScroll() {
        var pageTopbar = document.getElementById("page-topbar");
        if(pageTopbar){
            document.body.scrollTop >= 50 || document.documentElement.scrollTop >= 50 ? pageTopbar.classList.add("topbar-shadow") : pageTopbar.classList.remove("topbar-shadow");
        }}

    // Two-column menu activation
    function initTwoColumnActiveMenu() {
        feather.replace();
        // two column sidebar active js
        var currentPath = location.pathname == "/" ? "index.html" : location.pathname.substring(1);
        currentPath = currentPath.substring(currentPath.lastIndexOf("/") + 1);
        if (currentPath) {
            if(document.body.className == "twocolumn-panel"){
                document.getElementById("two-column-menu").querySelector('[href="' + currentPath + '"]').classList.add("active");
            }
            // navbar-nav
            var a = document.getElementById("navbar-nav").querySelector('[href="' + currentPath + '"]');
            if (a) {
                a.classList.add("active");
                var parentCollapseDiv = a.closest(".collapse.menu-dropdown");
                if (parentCollapseDiv && parentCollapseDiv.parentElement.closest(".collapse.menu-dropdown")) {
                    parentCollapseDiv.classList.add("show");
                    parentCollapseDiv.parentElement.children[0].classList.add("active");
                    parentCollapseDiv.parentElement.closest(".collapse.menu-dropdown").parentElement.classList.add("twocolumn-item-show");
                    if(parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse.menu-dropdown")){
                        var menuIdSub = parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse.menu-dropdown").getAttribute("id");
                        parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse.menu-dropdown").parentElement.classList.add("twocolumn-item-show");
                        parentCollapseDiv.parentElement.closest(".collapse.menu-dropdown").parentElement.classList.remove("twocolumn-item-show");
                        if (document.getElementById("two-column-menu").querySelector('[href="#' + menuIdSub + '"]'))
                            document.getElementById("two-column-menu").querySelector('[href="#' + menuIdSub + '"]').classList.add("active");
                    }
                    var menuId = parentCollapseDiv.parentElement.closest(".collapse.menu-dropdown").getAttribute("id");
                    if (document.getElementById("two-column-menu").querySelector('[href="#' + menuId + '"]'))
                        document.getElementById("two-column-menu").querySelector('[href="#' + menuId + '"]').classList.add("active");
                } else {
                    a.closest(".collapse.menu-dropdown").parentElement.classList.add("twocolumn-item-show");
                    var menuId = parentCollapseDiv.getAttribute("id");
                    if (document.getElementById("two-column-menu").querySelector('[href="#' + menuId + '"]'))
                        document.getElementById("two-column-menu").querySelector('[href="#' + menuId + '"]').classList.add("active");
                }
            } else {
                document.body.classList.add("twocolumn-panel");
            }
        }
    }

    // two-column sidebar active js
    function initActiveMenu() {
        var currentPath = location.pathname == "/" ? "index.html" : location.pathname.substring(1);
        currentPath = currentPath.substring(currentPath.lastIndexOf("/") + 1);
        if (currentPath) {
            // navbar-nav
            var a = document.getElementById("navbar-nav").querySelector('[href="' + currentPath + '"]');
            if (a) {
                a.classList.add("active");
                var parentCollapseDiv = a.closest(".collapse.menu-dropdown");
                if (parentCollapseDiv) {
                    parentCollapseDiv.classList.add("show");
                    parentCollapseDiv.parentElement.children[0].classList.add("active");
                    parentCollapseDiv.parentElement.children[0].setAttribute("aria-expanded", "true");
                    if (parentCollapseDiv.parentElement.closest(".collapse.menu-dropdown")) {
                        parentCollapseDiv.parentElement.closest(".collapse").classList.add("show");
                        if (parentCollapseDiv.parentElement.closest(".collapse").previousElementSibling)
                            parentCollapseDiv.parentElement.closest(".collapse").previousElementSibling.classList.add("active");

                        if (parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse.menu-dropdown")) {
                            parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse").classList.add("show");
                            if (parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse").previousElementSibling) {

                                parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse").previousElementSibling.classList.add("active");
                                if((document.documentElement.getAttribute("data-layout") == "horizontal") && parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.closest(".collapse")){
                                    parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.closest(".collapse").previousElementSibling.classList.add("active")
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    function updateHorizontalMenus() {
        document.getElementById("two-column-menu").innerHTML = "";
        if(document.querySelector(".navbar-menu")){
            document.querySelector(".navbar-menu").innerHTML = navbarMenuHTML;
        }
        document.getElementById("scrollbar").removeAttribute("data-simplebar");
        document.getElementById("navbar-nav").removeAttribute("data-simplebar");
        document.getElementById("scrollbar").classList.remove("h-100");

        var splitMenu = horizontalMenuSplit;
        var extraMenuName = "More";
        var menuData = document.querySelectorAll("ul.navbar-nav > li.nav-item");
        var newMenus = "";
        var splitItem = "";

        Array.from(menuData).forEach(function (item, index) {
            if (index + 1 === splitMenu) {
                splitItem = item;
            }
            if (index + 1 > splitMenu) {
                newMenus += item.outerHTML;
                item.remove();
            }

            if (index + 1 === menuData.length) {
                if (splitItem.insertAdjacentHTML) {
                    splitItem.insertAdjacentHTML(
                        "afterend",
                        '<li class="nav-item">\
                            <a class="nav-link" href="#sidebarMore" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMore">\
                                <i class="ri-briefcase-2-line"></i> ' + extraMenuName + '\
						</a>\
						<div class="collapse menu-dropdown" id="sidebarMore"><ul class="nav nav-sm flex-column">' + newMenus + "</ul></div>\
					</li>");
                }
            }
        });
    }

    function hideShowLayoutOptions(dataLayout) {
        if (dataLayout == "vertical") {
            document.getElementById("two-column-menu").innerHTML = "";
            if(document.querySelector(".navbar-menu")){
                document.querySelector(".navbar-menu").innerHTML = navbarMenuHTML;
            }
            if (document.getElementById("theme-settings-offcanvas")) {
                document.getElementById("sidebar-size").style.display = "block";
                document.getElementById("sidebar-view").style.display = "block";
                document.getElementById("sidebar-color").style.display = "block";
                if (document.getElementById("sidebar-img")) {
                    document.getElementById("sidebar-img").style.display = "block";
                }
                document.getElementById("layout-position").style.display = "block";
                document.getElementById("layout-width").style.display = "block";
            }
            initActiveMenu();
        } else if (dataLayout == "horizontal") {
            updateHorizontalMenus();
            if (document.getElementById("theme-settings-offcanvas")) {
                document.getElementById("sidebar-size").style.display = "none";
                document.getElementById("sidebar-view").style.display = "none";
                document.getElementById("sidebar-color").style.display = "none";
                if (document.getElementById("sidebar-img")) {
                    document.getElementById("sidebar-img").style.display = "none";
                }
                document.getElementById("layout-position").style.display = "block";
                document.getElementById("layout-width").style.display = "block";
            }
            initActiveMenu();
        } else if (dataLayout == "twocolumn") {
            document.getElementById("scrollbar").removeAttribute("data-simplebar");
            document.getElementById("scrollbar").classList.remove("h-100");
            if (document.getElementById("theme-settings-offcanvas")) {
                document.getElementById("sidebar-size").style.display = "none";
                document.getElementById("sidebar-view").style.display = "none";
                document.getElementById("sidebar-color").style.display = "block";
                if (document.getElementById("sidebar-img")) {
                    document.getElementById("sidebar-img").style.display = "block";
                }
                document.getElementById("layout-position").style.display = "none";
                document.getElementById("layout-width").style.display = "none";
            }
        }
    }

    // add change event listener on right layout setting
    function getElementUsingTagname(ele, val) {
        Array.from(document.querySelectorAll("input[name=" + ele + "]")).forEach(function (x) {
            val == x.value ? (x.checked = true) : (x.checked = false);

            x.addEventListener("change", function () {
                document.documentElement.setAttribute(ele, x.value);
                sessionStorage.setItem(ele, x.value);

                if (ele == "data-layout-width" && x.value == "boxed") {
                    document.documentElement.setAttribute("data-sidebar-size", "sm-hover");
                    sessionStorage.setItem("data-sidebar-size", "sm-hover");
                    document.getElementById("sidebar-size-small-hover").checked = true;
                } else if (ele == "data-layout-width" && x.value == "fluid") {
                    document.documentElement.setAttribute("data-sidebar-size", "lg");
                    sessionStorage.setItem("data-sidebar-size", "lg");
                    document.getElementById("sidebar-size-default").checked = true;
                }

                if (ele == "data-layout") {
                    if (x.value == "vertical") {
                        hideShowLayoutOptions("vertical");
                        feather.replace();
                    } else if (x.value == "horizontal") {
                        if (document.getElementById("sidebarimg-none")){
                            document.getElementById("sidebarimg-none").click();
                        }
                        hideShowLayoutOptions("horizontal");
                        feather.replace();
                    } else if (x.value == "twocolumn") {
                        hideShowLayoutOptions("twocolumn");
                        document.documentElement.setAttribute("data-layout-width", "fluid");
                        document.getElementById("layout-width-fluid").click();
                        initTwoColumnActiveMenu();
                        feather.replace();
                    }
                }

                if(ele == "data-preloader" && x.value == "enable"){
                    document.documentElement.setAttribute("data-preloader", "enable");
                    var preloader = document.getElementById("preloader");
                    if (preloader) {
                        setTimeout(function(){
                            preloader.style.opacity = "0";
                            preloader.style.visibility = "hidden";
                        }, 1000);
                    }
                    document.getElementById("customizerclose-btn").click();
                }else if(ele == "data-preloader" && x.value == "disable"){
                    document.documentElement.setAttribute("data-preloader", "disable");
                    document.getElementById("customizerclose-btn").click();
                }
            });
        });

        if (document.getElementById('collapseBgGradient')) {
            Array.from(document.querySelectorAll("#collapseBgGradient .form-check input")).forEach(function (subElem) {
                var myCollapse = document.getElementById('collapseBgGradient')
                if ((subElem.checked == true)) {
                    var bsCollapse = new bootstrap.Collapse(myCollapse, {
                        toggle: false,
                    })
                    bsCollapse.show()
                }

                if (document.querySelector("[data-bs-target='#collapseBgGradient']")) {
                    document.querySelector("[data-bs-target='#collapseBgGradient']").addEventListener('click', function (elem) {
                        document.getElementById("sidebar-color-gradient").click();
                    });
                }
            });
        }

        Array.from(document.querySelectorAll("[name='data-sidebar']")).forEach(function (elem) {
            if (document.querySelector("[data-bs-target='#collapseBgGradient']")) {
                if (document.querySelector("#collapseBgGradient .form-check input:checked")) {
                    document.querySelector("[data-bs-target='#collapseBgGradient']").classList.add("active");
                } else {
                    document.querySelector("[data-bs-target='#collapseBgGradient']").classList.remove("active");
                }

                elem.addEventListener("change", function () {
                    if (document.querySelector("#collapseBgGradient .form-check input:checked")) {
                        document.querySelector("[data-bs-target='#collapseBgGradient']").classList.add("active");
                    } else {
                        document.querySelector("[data-bs-target='#collapseBgGradient']").classList.remove("active");
                    }
                })
            }
        })

    }

    function init() {
        windowLoadContent();
    }
    init();

    var timeOutFunctionId;

    function setResize() {
        var currentLayout = document.documentElement.getAttribute("data-layout");
        if (currentLayout !== "horizontal") {
            if (document.getElementById("navbar-nav")) {
                var simpleBar = new SimpleBar(document.getElementById("navbar-nav"));
                if (simpleBar) simpleBar.getContentElement();
            }

            if (document.getElementsByClassName("twocolumn-iconview")[0]) {
                var simpleBar1 = new SimpleBar(
                    document.getElementsByClassName("twocolumn-iconview")[0]
                );
                if (simpleBar1) simpleBar1.getContentElement();
            }
            clearTimeout(timeOutFunctionId);
        }
    }

    window.addEventListener("resize", function () {
        if (timeOutFunctionId) clearTimeout(timeOutFunctionId);
        timeOutFunctionId = setTimeout(setResize, 2000);
    });
})();


//
/********************* scroll top js ************************/
//
