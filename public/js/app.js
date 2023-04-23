const semesterSelect = document.getElementById('semester-select');
const facultySelect = document.getElementById('faculty-select');
const facultyList = document.querySelectorAll('#faculty-list li');
semesterSelect.addEventListener('change', () => {
  const selectedSemester = semesterSelect.value;
  
  // Reset faculty dropdown
  facultySelect.innerHTML = '<option value="none">Select Faculty</option>';
  
  // Populate faculty dropdown based on selected semester
  facultyList.forEach(faculty => {
    if (faculty.classList.contains(selectedSemester)) {
      const facultyName = faculty.textContent;
      const facultyOption = document.createElement('option');
      facultyOption.value = facultyName;
      facultyOption.textContent = facultyName;
      facultySelect.appendChild(facultyOption);
    }
  });
});
