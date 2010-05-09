<?php
// ------------ lixlpixel recursive PHP functions -------------
// scan_directory_recursively( directory to scan, filter )
// expects path to directory and optional an extension to filter
// ------------------------------------------------------------
function scan_directory_recursively($directory, $filter=FALSE)
{
	if(substr($directory,-1) == '/')
	{
		$directory = substr($directory,0,-1);
	}
	if(!file_exists($directory) || !is_dir($directory))
	{
		return FALSE;
	}elseif(is_readable($directory))
	{
		$directory_list = opendir($directory);
		while($file = readdir($directory_list))
		{
			if($file != '.' && $file != '..' && $file != '.DS_Store' && $file != '.svn')
			{
				$path = $directory.'/'.$file;
				if(is_readable($path))
				{
					$subdirectories = explode('/',$path);
					if(is_dir($path))
					{
						$directory_tree[] = array(
							'path'      => $path,
							'name'      => end($subdirectories),
							'modified'	=> filemtime($path),
							'kind'      => 'directory',
							'content'   => scan_directory_recursively($path, $filter));
					}elseif(is_file($path))
					{
						$extension = end(explode('.',end($subdirectories)));
						if($filter === FALSE || $filter == $extension)
						{
							// Get metadata and image dimensions
							$size = getimagesize($path, $info);
							
							// Get containing directory of file
							$directory_array = explode('/', $path);
							$parent_folder = min($directory_array);
							
							// Reset title, caption, tags
							$title = $caption = $taglist = $tags = '';
							
							$directory_tree[] = array(
							'path'		=> dirname($path),
							'group'		=> $parent_folder,
							'file'		=> end($subdirectories),
							'extension' => $extension,
							'size'		=> filesize($path),
							'width'		=> $size[0],
							'height'	=> $size[1],
							'modified'	=> filemtime($path),
							'title'		=> $title,
							'caption'	=> $caption,
							'tags'		=> $tags,
							'kind'		=> 'file');
						}
					}
				}
			}
		}
		closedir($directory_list); 
		return $directory_tree;
	}else{
		return FALSE;	
	}
}
?>