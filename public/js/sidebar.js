(() => {
    // Sidebar is now controlled by Alpine.js x-data on the body
    // This script handles keyboard and resize events

    // Close sidebar on Escape key
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            // Trigger Alpine.js data update
            const body = document.body;
            if (body.__x) {
                body.__x.$data.sidebarOpen = false;
            }
        }
    });

    // Close sidebar on window resize to desktop
    window.addEventListener("resize", () => {
        if (window.innerWidth >= 1024) {
            const body = document.body;
            if (body.__x) {
                body.__x.$data.sidebarOpen = false;
            }
        }
    });
})();
