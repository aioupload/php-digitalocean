<?php

	// Base URL for sending requests to DigitalOcean - shouldn't need to be changed.
	define ("base_url", "https://api.digitalocean.com/");


class DigitalOcean {
	public $client_id = "";
	public $api_key = "";
	
	public function __construct($passed_client_id, $passed_api_key) {
		$this->client_id = $passed_client_id;
		$this->api_key = $passed_api_key;
	}

	// Retrieves a list of droplets on your account.
	// Returns a multidimensional array containing droplet info on success, or throws an exception on error.
	public function droplets() {
		$response = $this->make_get_request("droplets/?");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['droplets'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}
	
	// Retrieves a count of droplets on your account.
	// Returns the value.
	public function droplets_count() {
		$response = $this->droplets();
		if ($response) {
			return count($response);
		} else {
			return false;
		}
	}
	
	// Retrieves information for specified $dropletid.
	// Returns an array on success or throws an exception on error or null return.
	public function droplet_info($dropletid) {
		$response = $this->make_get_request("droplets/".$dropletid."?");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['droplet'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}
	
	// Creates a new Droplet.
	// Returns an array of new droplet parameters on success or throws an exception on error.
	public function droplet_new($name, $size_id, $image_id, $region_id) {
		$response = $this->make_get_request("droplets/new?name=".$name."&size_id=".$size_id."&image_id=".$image_id."&region_id=".$region_id."&");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['droplet'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}
		
	// Reboots a droplet.
	// Returns the event_id on success or throws an exception on error.
	public function droplet_reboot($dropletid) {
		$response = $this->make_get_request("droplets/".$dropletid."/reboot/?");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['event_id'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}
	
	// Power-cycles a droplet.
	// Returns the event_id on success or throws an exception on error.
	public function droplet_power_cycle($dropletid) {
		$response = $this->make_get_request("droplets/".$dropletid."/power_cycle/?");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['event_id'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}

	// Shuts-down a droplet (but you still continue to be charged).
	// Returns the event_id on success, or throws an exception on error.
	public function droplet_shutdown($dropletid) {
		$response = $this->make_get_request("droplets/".$dropletid."/shutdown/?");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['event_id'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}
	
	// Hard powers-off a droplet (but you still continue to be charged).
	// Returns the event_id on success, or throws an exception on error.
	public function droplet_power_off($dropletid) {
		$response = $this->make_get_request("droplets/".$dropletid."/power_off/?");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['event_id'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}
	
	// Powers-on a droplet that was previously shut down or powered-off.
	// Returns the event_id on success, or throws an exception on error.
	public function droplet_power_on($dropletid) {
		$response = $this->make_get_request("droplets/".$dropletid."/power_on/?");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['event_id'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}
	
	// Resets the password on a droplet. The new password is e-mailed to the account e-mail address
	// Returns the event_id on success, or throws an exception on error.
	public function droplet_password_reset($dropletid) {
		$response = $this->make_get_request("droplets/".$dropletid."/password_reset/?");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['event_id'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}	

	// Destroys a droplet (you stop being charged for it). This is irreversable.
	// Returns the event_id on success, or throws an exception on error.
	public function droplet_destroy($dropletid) {
		$response = $this->make_get_request("droplets/".$dropletid."/destroy/?");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['event_id'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}	

	// Takes a snapshot of the droplet. This may cause a reboot.
	// Returns the event_id on success, or throws an exception on error.
	public function droplet_take_snapshot($dropletid, $snapshotname) {
		$response = $this->make_get_request("droplets/".$dropletid."/snapshot/?name=".$snapshotname."&");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['event_id'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}
	
	// Resizes the droplet. First call sizes() to get the ID of the size you want.
	// Returns the event_id on success, or throws an exception on error.
	public function droplet_resize($dropletid, $sizeid) {
		$response = $this->make_get_request("droplets/".$dropletid."/resize/?size_id=".$sizeid."&");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['event_id'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}
	
	// Erases and rebuilds the droplet with a default image. First call images() to get the ID of the image you want.
	// Returns the event_id on success, or throws an exception on error.
	public function droplet_rebuild($dropletid, $imageid) {
		$response = $this->make_get_request("droplets/".$dropletid."/rebuild/?image_id=".$imageid."&");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['event_id'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}	
	
	// Renames the droplet.
	// Returns the event_id on success, or throws an exception on error.
	public function droplet_rename($dropletid, $newname) {
		$response = $this->make_get_request("droplets/".$dropletid."/rename/?name=".$newname."&");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['event_id'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}	

	// Enables automated backups on a droplet.
	// Returns the event_id on success, or throws an exception on error.
	public function droplet_enable_backups($dropletid) {
		$response = $this->make_get_request("droplets/".$dropletid."/enable_backups/?");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['event_id'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}
	
	// Disables automated backups on a droplet.
	// Returns the event_id on success, or throws an exception on error.
	public function droplet_disable_backups($dropletid) {
		$response = $this->make_get_request("droplets/".$dropletid."/disable_backups/?");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['event_id'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}
	
	// Retrieves a list of available droplet sizes and ID's, used for creating or resizing droplets.
	// Returns a multidimensional array of droplet sizes and IDs on success, or throws an exception on error.
	public function sizes() {
		$response = $this->make_get_request("sizes/?");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['sizes'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}
	
	// Retrieves a list of available regions and ID's, used for creating droplets.
	// Returns a multidimensional array of regions, or throws an exception on error.
	public function regions() {
		$response = $this->make_get_request("regions/?");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['regions'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}
	
	// Retrieves a list of available machine-images - public images and snapshots/backups you've made.
	// Returns a multidimensional array of machine-images, or throws an exception on error.
	public function images() {
		$response = $this->make_get_request("images/?");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['images'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}
	
	// Retrieves a count of images on your account.
	// Returns the value, or false on failure.
	public function images_count() {
		$response = $this->images();
		if ($response) {
			return count($response);
		} else {
			return false;
		}
	}	
	
	// Retrieves information on the specified machine-image.
	// Returns an array on success, or throws an exception on error.
	public function image_info($imageid) {
		$response = $this->make_get_request("images/".$imageid."/?");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return $response[1]['image'];
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}
	
	// Destroys the specified machine-image.
	// Returns true on success, or throws an exception on error.
	public function image_destroy($imageid) {
		$response = $this->make_get_request("images/".$imageid."/destroy/?");
		if ($this->was_response_ok($response[0])) {
			if ($response[1]['status'] == "OK") {
				return true;
			} else {
				throw new Exception($response[1]['error_message']);
			}
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}
		
	// Retrieves information on a specified event, e.g. so you can monitor long-running events.
	// Returns an array on success, or throws an exception on error.
	public function event_info($eventid) {
		$response = $this->make_get_request("events/".$eventid."/?");
		if ($this->was_response_ok($response[0])) {
			return $response[1];
		} else {
			throw new Exception('Non-200 HTTP status code. Check your API key or method');
		}
	}
	
	protected function make_get_request($url) {
		$urltoget = base_url.$url."client_id=".$this->client_id."&api_key=".$this->api_key;
		$response = @file_get_contents($urltoget);
		return array($http_response_header[0], json_decode($response, true));
	}
	
	protected function was_response_ok($status) {
		if ($status == "HTTP/1.1 200 OK") {
			return true;
		} else {
			return false;
		}
	}

}

?>