
// **********************************************************************************************************
//                           Set All Vegetables to the Array in State
// **********************************************************************************************************
export const toggle_dialog = (state) => {
    return state.dialog = !state.dialog
}

// **********************************************************************************************************
//                           Set All Vegetables to the Array in State
// **********************************************************************************************************
export const set_edit_item = (state,item) => {
    return state.editItem = item
}

// **********************************************************************************************************
//                           Set All Vegetables to the Array in State
// **********************************************************************************************************
export const set_all_users = (state, items) => {
    return state.items = items
}

// **********************************************************************************************************
//                           Set All Vegetables to the Array in State
// **********************************************************************************************************
export const set_active_users = (state, items) => {
    return state.activeItem = items
}