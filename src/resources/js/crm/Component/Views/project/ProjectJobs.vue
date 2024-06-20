<template>
    <div>
      <h2>{{ project.name }} Jobs</h2>
      <ul v-if="jobs.length > 0">
        <li v-for="job in jobs" :key="job.id">
          <h3>{{ job.title }}</h3>
          <p>Worker: {{ job.worker.name }}</p>
          <p>Tasks:</p>
          <ul>
            <li v-for="task in job.tasks" :key="task.id">
              {{ task.name }}
            </li>
          </ul>
        </li>
      </ul>
      <p v-else>No jobs found.</p>
    </div>
  </template>
  
  <script>
  export default {
    name: 'ProjectJobs',
    data() {
      return {
        project: null,
        jobs: [],
      };
    },
    methods: {
      fetchProjectJobs() {
        const projectId = this.$route.params.projectId; // Assuming you're using Vue Router
        
        // Make API request to fetch project jobs
        axios.get(`/api/projects/${projectId}/jobs`)
          .then(response => {
            this.project = response.data.project; // Assuming API returns project data
            this.jobs = response.data.jobs;
          })
          .catch(error => {
            console.error('Error fetching project jobs:', error);
          });
      },
    },
    mounted() {
      this.fetchProjectJobs(); // Fetch jobs when component mounts
    },
  };
  </script>
  
  <style>
  /* Your component styles */
  </style>
  