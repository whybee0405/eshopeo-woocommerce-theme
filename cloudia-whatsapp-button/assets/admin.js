document.addEventListener('DOMContentLoaded', function () {
  const tables = document.querySelectorAll('.cwb-admin table.widefat');
  tables.forEach(function (table) {
    table.querySelectorAll('a[target="_blank"]').forEach(function (link) {
      link.rel = 'noopener';
    });
  });

  const branches = document.querySelector('[data-cwb-branches]');
  if (!branches) return;

  const list = branches.querySelector('[data-cwb-branch-list]');
  const template = branches.querySelector('[data-cwb-branch-template]');
  let nextIndex = list.querySelectorAll('[data-cwb-branch-row]').length;

  branches.querySelector('[data-cwb-add-branch]').addEventListener('click', function () {
    const markup = template.innerHTML.replaceAll('__INDEX__', String(nextIndex));
    nextIndex += 1;
    list.insertAdjacentHTML('beforeend', markup);
    list.querySelector('[data-cwb-branch-row]:last-child input').focus();
  });

  list.addEventListener('click', function (event) {
    const remove = event.target.closest('[data-cwb-remove-branch]');
    if (remove) remove.closest('[data-cwb-branch-row]').remove();
  });
});
