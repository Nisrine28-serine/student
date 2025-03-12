function toggleSidebar() {
    document.body.classList.toggle('sidebar-collapsed');
    
    // Save state to localStorage
    const isSidebarCollapsed = document.body.classList.contains('sidebar-collapsed');
    localStorage.setItem('sidebar-collapsed', isSidebarCollapsed);
}

// Check localStorage on page load to restore sidebar state
document.addEventListener('DOMContentLoaded', function() {
    const isSidebarCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
    if (isSidebarCollapsed) {
        document.body.classList.add('sidebar-collapsed');
    }
});