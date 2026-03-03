(() => {
    const sidebar = document.getElementById("appSidebar");
    const backdrop = document.getElementById("sidebarBackdrop");
    const openBtn = document.getElementById("sidebarToggleBtn");
    const closeBtn = document.getElementById("sidebarCloseBtn");

    function open() {
        sidebar.classList.add("sidebar-open");
        backdrop.classList.add("active");
        document.body.style.overflow = "hidden";
    }

    function close() {
        sidebar.classList.remove("sidebar-open");
        backdrop.classList.remove("active");
        document.body.style.overflow = "";
    }

    function toggle() {
        sidebar.classList.contains("sidebar-open") ? close() : open();
    }

    openBtn && openBtn.addEventListener("click", toggle);
    closeBtn && closeBtn.addEventListener("click", close);
    backdrop && backdrop.addEventListener("click", close);

    document.addEventListener("keydown", (e) => e.key === "Escape" && close());
    window.addEventListener(
        "resize",
        () => window.innerWidth >= 992 && close(),
    );
})();
