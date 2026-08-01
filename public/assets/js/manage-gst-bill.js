document.addEventListener('DOMContentLoaded', function () {
  const billSearch = document.getElementById('billSearch');
  const billSuggestions = document.getElementById('billSuggestions');

  if (!billSearch || !billSuggestions) {
    return;
  }

  const bills = window.gstBillSearchData || [];

  function filterBills(query) {
    const rows = document.querySelectorAll('#tickets-table tbody tr');
    rows.forEach(function (row) {
      if (!row.getAttribute('data-search')) {
        return;
      }

      const text = row.getAttribute('data-search') || '';
      const matches = text.includes(query);
      row.style.display = matches ? '' : 'none';
    });
  }

  billSearch.addEventListener('input', function () {
    const query = this.value.toLowerCase().trim();
    billSuggestions.innerHTML = '';

    if (!query) {
      billSuggestions.style.display = 'none';
      filterBills('');
      return;
    }

    const matches = bills.filter(function (bill) {
      return (bill.invoice_number + ' ' + bill.party_name).toLowerCase().includes(query);
    }).slice(0, 8);

    if (!matches.length) {
      billSuggestions.style.display = 'none';
      filterBills(query);
      return;
    }

    billSuggestions.style.display = 'block';
    matches.forEach(function (bill) {
      const item = document.createElement('button');
      item.type = 'button';
      item.className = 'list-group-item list-group-item-action text-left';
      item.textContent = bill.label;
      item.addEventListener('click', function () {
        billSearch.value = bill.label;
        billSuggestions.style.display = 'none';
        filterBills((bill.invoice_number + ' ' + bill.party_name).toLowerCase());
      });
      billSuggestions.appendChild(item);
    });

    filterBills(query);
  });

  document.addEventListener('click', function (event) {
    if (!billSuggestions.contains(event.target) && event.target !== billSearch) {
      billSuggestions.style.display = 'none';
    }
  });
});
