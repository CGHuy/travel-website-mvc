
document.addEventListener('DOMContentLoaded', function(){
  const modal = document.getElementById('serviceModal');
  const modalTitle = document.getElementById('serviceModalTitle');
  const form = modal.querySelector('form');

  document.querySelectorAll('.btn-edit-service').forEach(btn => {
    btn.addEventListener('click', function(){
      const id = this.dataset.id;
      const name = this.dataset.name || '';
      const slug = this.dataset.slug || '';
      const description = this.dataset.description || '';
      const serviceCode = this.dataset.serviceCode || '';
      const status = this.dataset.status == '1';

      modalTitle.textContent = 'Sửa Dịch vụ';
      form.action = '?controller=Service&action=update&id=' + id;

      form.querySelector('[name="name"]').value = name;
      form.querySelector('[name="slug"]').value = slug;
      form.querySelector('[name="description"]').value = description;
      form.querySelector('#service-status').checked = status;

      if (serviceCode) {
        const scField = form.querySelector('.service-code-display');
        if (scField) scField.value = serviceCode;
      }

     bootstrap.Modal.getOrCreateInstance(modal).show();

    });
  });

  modal.addEventListener('hidden.bs.modal', function(){
    modalTitle.textContent = 'Thêm Dịch vụ';
    form.action = '?controller=Service&action=store';
    form.reset();
  });
});

// ===== SEARCH SERVICE =====
const searchForm = document.getElementById('service-search-form');
const keywordInput = document.getElementById('service-search-keyword');

if (searchForm && keywordInput) {
  searchForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const keyword = keywordInput.value.trim();

    const url =
      '?controller=Service&action=index&keyword=' +
      encodeURIComponent(keyword);

    window.location.href = url;
  });
}
