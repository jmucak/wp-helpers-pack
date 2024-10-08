<?php

namespace jmucak\wpHelpersPack;

class FileHelper {
	public static function convert_file_size_to_readable_size( int $size ): string {
		$base   = log( $size ) / log( 1024 );
		$suffix = array( '', 'KB', 'MB', 'GB', 'TB' );
		$f_base = floor( $base );

		return round( pow( 1024, $base - floor( $base ) ), 1 ) . $suffix[ $f_base ];
	}
}