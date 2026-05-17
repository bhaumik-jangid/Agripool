// District data from PHP — loaded inline in views
// filterDistricts(prefix) — called when state changes
function filterDistricts(prefix) {
    const stateSelect    = document.getElementById(prefix + 'State');
    const districtSelect = document.getElementById(prefix + 'District');
    const selectedState  = stateSelect.value;

    // Clear existing options
    districtSelect.innerHTML = '<option value="">Select district</option>';

    if (!selectedState || !window.stateDistricts[selectedState]) return;

    // Get sorted districts for this state
    const districts = Object.keys(window.stateDistricts[selectedState])
                            .sort();

    districts.forEach(function(district) {
        const opt    = document.createElement('option');
        opt.value    = district;
        opt.textContent = district;
        districtSelect.appendChild(opt);
    });

    // Trigger cost estimate update
    if (typeof updateCostEstimate === 'function') {
        updateCostEstimate();
    }
}