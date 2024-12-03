import Alpine, { AlpineComponent } from "alpinejs";

import { ManageMember } from "./types";
import {
  deleteMember,
  fillUpdateModalInputs,
  toggleAddModal,
  toggleUpdateModal,
  addNewMember,
} from "./helpers";

//@ts-ignore
window.Alpine = Alpine;

Alpine.data(
  "manageMembers",
  (): AlpineComponent<ManageMember> => ({
    deleteMember,
    fillUpdateModalInputs,
    openAddModal: false,
    openUpdateModal: false,
    toggleAddModal,
    toggleUpdateModal,
    addNewMember,
  })
);

Alpine.start();

//@ts-ignore
console.log("Nonce: ", wpApiAuth.nonce);
