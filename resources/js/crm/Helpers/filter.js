
import Vue from "vue";

    document.addEventListener('DOMContentLoaded', function() {
    // Initialize Flatpickr on the date input fields
    flatpickr("#proposal_date, #start_date, #due_date, #end_date", {
        dateFormat: "Y-m-d",
        disableMobile: true // optional: to force the desktop version on mobile devices
    });

    document.querySelectorAll('.edit-project-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var projectId = this.getAttribute('data-id');
            var url = "{{ route('projects.edit', ['project' => ':id']) }}".replace(':id', projectId);

            console.log('Project ID:', projectId); // Log the project ID
            console.log('URL:', url); // Log the URL

            // AJAX request to fetch project details
            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' // Ensure the request is identified as AJAX
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Fetched data:', data); // Log the fetched data

                const project = data.project;
                const organization = data.organization;

                // Check if the form and its fields exist before populating them
                const editProjectForm = document.getElementById('editProjectForm');
                if (!editProjectForm) {
                    throw new Error('Edit Project Form not found');
                }

                editProjectForm.setAttribute('action', "{{ route('projects.update', 0) }}".replace('/0', '/' + project.id));
                const nameField = document.querySelector('#editProjectForm input[name="name"]');
                const descriptionField = document.querySelector('#editProjectForm textarea[name="description"]');
                const proposalDateField = document.querySelector('#editProjectForm input[name="proposal_date"]');
                const startDateField = document.querySelector('#editProjectForm input[name="start_date"]');
                const dueDateField = document.querySelector('#editProjectForm input[name="due_date"]');
                const endDateField = document.querySelector('#editProjectForm input[name="end_date"]');
                const statusField = document.querySelector('#editProjectForm select[name="status_id"]');
                const organizationField = document.querySelector('#editProjectForm select[name="organization_id"]');

                if (nameField) nameField.value = project.name;
                if (descriptionField) descriptionField.value = project.description;
                if (proposalDateField) proposalDateField.value = project.proposal_date;
                if (startDateField) startDateField.value = project.start_date;
                if (dueDateField) dueDateField.value = project.due_date;
                if (endDateField) endDateField.value = project.end_date;
                if (statusField) statusField.value = project.status_id;
                if (organizationField) organizationField.value = project.organization_id;

                // Show the modal
                $('#editProjectModal').modal('show');
            })
            .catch(error => {
                console.error('Error fetching project data:', error);
            });
        });
    });

    document.getElementById("projectstage").addEventListener("click", toggleDropdown);

    function toggleDropdown() {
        var dropdown = document.getElementById('progressDropdown');
        if (dropdown.style.display === "block") {
            dropdown.style.display = "none";
        } else {
            closeAllDropdowns();
            dropdown.style.display = "block";
        }
    }

    document.getElementById("datefilter").addEventListener("click", function() { 
        event.stopPropagation();
        var dropdown = document.getElementById('dateDropdown');
        if (dropdown.style.display === "block") {
            dropdown.style.display = "none";
        } else {
            closeAllDropdowns();
            dropdown.style.display = "block";

        flatpickr("#startDate", {
            dateFormat: "Y-m-d"
        });

        flatpickr("#endDate", {
            dateFormat: "Y-m-d"
        });

            }
    });

    document.getElementById("clearDates").addEventListener("click", function() {
        document.getElementById("startDate")._flatpickr.clear();
        document.getElementById("endDate")._flatpickr.clear();
    });

    document.getElementById("applyDates").addEventListener("click", function() {
        var startDate = document.getElementById("startDate").value;
        var endDate = document.getElementById("endDate").value;
        console.log("Start Date:", startDate, "End Date:", endDate);
        // Add your code to handle the selected dates
        toggleDropdown('dateDropdown');
    });

    function updateButtonText(buttonId, text) {
        var button = document.getElementById(buttonId);
        button.innerText = text;
    }

    document.getElementById("Organizationlist").addEventListener("click", function() {
        var dropdown = document.getElementById('organizationDropdown');
        if (dropdown.style.display === "block") {
            dropdown.style.display = "none";
        } else {
            closeAllDropdowns();
            dropdown.style.display = "block";

            var url = `{{ route('organization.get') }}`;

            console.log(url)
            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Fetched data:', data);

                const organizationListContainer = document.getElementById('organizationListContainer');
                organizationListContainer.innerHTML = '';                  
                const hr = document.createElement('hr');


                for (const [id, name] of Object.entries(data)) {
                    const listItem = document.createElement('li');

                    
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.id = `organization-${id}`;
                    checkbox.value = id;
                    checkbox.classList.add('organization-checkbox');

                    const label = document.createElement('label');
                    label.htmlFor = `organization-${id}`;
                    label.textContent = name;

                    listItem.appendChild(checkbox);
                    listItem.appendChild(label);
                    listItem.classList.add('organization-item');
                    
                    organizationListContainer.appendChild(listItem);
                }
                organizationListContainer.appendChild(hr);

            })
            .catch(error => {
                console.error('Error fetching organization data:', error);
            });
        }
    });

    document.getElementById("clearOrganizations").addEventListener("click", function() {
        const checkboxes = document.querySelectorAll('.organization-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
    });

    document.getElementById("applyOrganizations").addEventListener("click", function() {
        const selectedOrganizations = [];
        const checkboxes = document.querySelectorAll('.organization-checkbox:checked');
        checkboxes.forEach(checkbox => {
            selectedOrganizations.push({
                id: checkbox.value,
                name: checkbox.nextElementSibling.textContent
            });
        });
        console.log('Selected Organizations:', selectedOrganizations);
        document.getElementById('organizationDropdown').style.display = 'none';
    });


    function selectOrganization(id, name) {
        console.log('Selected Organization:', id, name);
        document.getElementById('organizationDropdown').style.display = 'none';
    }

    document.getElementById("it-has").addEventListener("click", toggleIsWith);

    function toggleIsWith(event) {
        event.stopPropagation();
        var dropdown = document.getElementById('classDropdown');
        if (dropdown.style.display === "block") {
            dropdown.style.display = "none";
        } else {
            closeAllDropdowns();
            dropdown.style.display = "block";
        }
    }

    document.getElementById("clearClauses").addEventListener("click", function() {
        const checkboxes = document.querySelectorAll('#clausesForm input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
    });

    document.getElementById("applyClauses").addEventListener("click", function() {
        const selectedClauses = [];
        const checkboxes = document.querySelectorAll('#clausesForm input[type="checkbox"]:checked');
        checkboxes.forEach(checkbox => {
            selectedClauses.push(checkbox.name);
        });
        console.log('Selected Clauses:', selectedClauses);
        document.getElementById('classDropdown').style.display = 'none';
    });

    document.getElementById("Projectvalue").addEventListener("click", toggleProjectValue);

    function toggleProjectValue(event) {
        event.stopPropagation();
        var dropdown = document.getElementById('valueDropdown');
        if (dropdown.style.display === "block") {
            dropdown.style.display = "none";
        } else {
            closeAllDropdowns();
            dropdown.style.display = "block";
        }
    }

    document.getElementById("clearValues").addEventListener("click", function() {
        document.getElementById("minValue").value = '';
        document.getElementById("maxValue").value = '';
    });

    document.getElementById("applyValues").addEventListener("click", function() {
        var minValue = document.getElementById("minValue").value;
        var maxValue = document.getElementById("maxValue").value;
        console.log("Min Value:", minValue, "Max Value:", maxValue);
        // Add your code to handle the selected values
        document.getElementById('valueDropdown').style.display = 'none';
    });


    function closeAllDropdowns() {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            dropdowns[i].style.display = "none";
        }
    }

    window.onclick = function(event) {
        if (!event.target.matches('.filter-btn') && !event.target.closest('.dropdown-content')) {
            closeAllDropdowns();
        }
    }

});