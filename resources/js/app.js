import "./../../vendor/power-components/livewire-powergrid/dist/bootstrap5.css";
import "bootstrap-icons/font/bootstrap-icons.css";
import "./bootstrap";

const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);
