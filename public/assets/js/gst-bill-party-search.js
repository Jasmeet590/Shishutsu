document.addEventListener('DOMContentLoaded', function () {
  const partySuggestions = document.getElementById('partySuggestions');
  const partySearch = document.getElementById('partySearch');
  const partyId = document.getElementById('partyId');

  if (!partySuggestions || !partySearch || !partyId) {
    return;
  }

  const parties = window.gstPartySearchData || [];

  partySearch.addEventListener('input', function () {
    const query = this.value.toLowerCase().trim();
    partySuggestions.innerHTML = '';

    if (!query) {
      partySuggestions.style.display = 'none';
      partyId.value = '';
      return;
    }

    const matches = parties.filter(function (party) {
      return party.name.toLowerCase().includes(query);
    }).slice(0, 8);

    if (!matches.length) {
      partySuggestions.style.display = 'none';
      partyId.value = '';
      return;
    }

    partySuggestions.style.display = 'block';
    matches.forEach(function (party) {
      const item = document.createElement('button');
      item.type = 'button';
      item.className = 'list-group-item list-group-item-action';
      item.textContent = party.name;
      item.addEventListener('click', function () {
        partySearch.value = party.name;
        partyId.value = party.id;
        partySuggestions.style.display = 'none';
      });
      partySuggestions.appendChild(item);
    });
  });

  document.addEventListener('click', function (event) {
    if (!partySuggestions.contains(event.target) && event.target !== partySearch) {
      partySuggestions.style.display = 'none';
    }
  });
});
