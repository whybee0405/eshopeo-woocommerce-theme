document.addEventListener('DOMContentLoaded', function () {
  const tables = document.querySelectorAll('.cwb-admin table.widefat');
  tables.forEach(function (table) {
    table.querySelectorAll('a[target="_blank"]').forEach(function (link) {
      link.rel = 'noopener';
    });
  });
});
