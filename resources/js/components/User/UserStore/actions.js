// **********************************************************************************************************
//                           Get all Banks in database with Pagination
// **********************************************************************************************************
export const toggle_dialog = ({ commit }) => {
    commit('toggle_dialog')
}

// **********************************************************************************************************
//                           Get all Banks in database with Pagination
// **********************************************************************************************************
export const set_edit_item = ({ commit },item) => {
    commit('set_edit_item',item)
}

// **********************************************************************************************************
//                           Get all Banks in database with Pagination
// **********************************************************************************************************
export const get_user_list = ({ commit }, page) => {
    return new Promise((resolve, reject) => {
        axios.get(`api/users?page=${page}`).then(response => {
            // Response data store the state array through mutation
            commit('set_all_users', response.data)
            resolve(response.data);
        }, error => {
            reject(error);
        })
    })
}

// **********************************************************************************************************
//                           Get all Banks in database with Pagination
// **********************************************************************************************************
export const add_new_user = ({ commit }, item) => {
    return new Promise((resolve, reject) => {
        axios.post('api/users',item).then(response => {
            // Response data store the state array through mutation
            resolve(response.data);
        }, error => {
            reject(error);
        })
    })
}

// **********************************************************************************************************
//                           Get all Banks in database with Pagination
// **********************************************************************************************************
export const get_user_details = ({ commit }, id) => {
    return new Promise((resolve, reject) => {
        axios.get(`api/users/${id}`).then(response => {
            commit('set_active_users', response.data)
            resolve(response.data);
        }, error => {
            reject(error);
        })
    })
}

// **********************************************************************************************************
//                           Get all Banks in database with Pagination
// **********************************************************************************************************
export const update_user = ({ commit }, item) => {
    return new Promise((resolve, reject) => {
        axios.put(`api/users/${item.id}`,item).then(response => {
            // Response data store the state array through mutation
            resolve(response.data);
        }, error => {
            reject(error);
        })
    })
}

// **********************************************************************************************************
//                           Get all Banks in database with Pagination
// **********************************************************************************************************
export const delete_user = ({ dispatch },id) => {
    return new Promise((resolve, reject) => {
        axios.delete(`api/users/${id}`).then(response => {
            dispatch('get_user_list');
            resolve(response.data);
        }, error => {
            reject(error);
        })
    })
}

// **********************************************************************************************************
//                           Get all Banks in database with Pagination
// **********************************************************************************************************
export const farner_search = ({ commit },query) => {
    return new Promise((resolve, reject) => {
        axios.get(`api/users/searchFarmer`,{params: { searchquery: query }}).then(response => {
            commit('set_all_users', response.data)
            resolve(response.data);
        }, error => {
            reject(error);
        })
    })
}