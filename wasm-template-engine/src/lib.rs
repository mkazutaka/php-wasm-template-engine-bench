extern crate askama;

use askama::Template;
use std::ffi::{CStr, CString};
use std::mem;
use std::os::raw::{c_char, c_void};

#[derive(Template)]
#[template(path = "index.html")]
struct IndexTemplate {}

#[no_mangle]
pub extern "C" fn hello() -> *mut c_char {
    let index = IndexTemplate {};
    unsafe { CString::from_vec_unchecked(index.render().unwrap().into_bytes()) }.into_raw()
}

#[no_mangle]
pub extern "C" fn allocate(size: usize) -> *mut c_void {
    let mut buffer = Vec::with_capacity(size);
    let pointer = buffer.as_mut_ptr();
    mem::forget(buffer);

    pointer as *mut c_void
}

#[no_mangle]
pub extern "C" fn deallocate(pointer: *mut c_void, capacity: usize) {
    unsafe {
        let _ = Vec::from_raw_parts(pointer, 0, capacity);
    }
}

#[cfg(test)]
mod tests {
    #[test]
    fn it_works() {
        assert_eq!(2 + 2, 4);
    }
}
