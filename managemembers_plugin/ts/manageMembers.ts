import Alpine, { AlpineComponent } from "alpinejs";

import { ManageMember } from "./types";
import {
  deleteMember,
  fillUpdateModalInputs,
  toggleAddModal,
  toggleUpdateModal,
  addNewMember,
  updateMember,
  getMembers,
  renderPagination,
  nextPage,
  previousPage,
  goToPage,
} from "./helpers";

//@ts-ignore
window.Alpine = Alpine;

Alpine.data(
  "manageMembers",
  (): AlpineComponent<ManageMember> => ({
    addNewMember,
    currentPage:0,
    deleteMember,
    fillUpdateModalInputs,
    limit:10,
    offset:0,
    openAddModal: false,
    openUpdateModal: false,
    pages:1,
    showPages:[],
    toggleAddModal,
    toggleUpdateModal,
    updateMember,
    getMembers,
    renderPagination,
    nextPage,
    previousPage,
    goToPage
    })
);

Alpine.start();




