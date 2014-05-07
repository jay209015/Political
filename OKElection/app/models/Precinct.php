/**
 * Represents precinct/district information.
 */
class Precinct extends Eloquent {
	protected $fillable = [];
	
	/**
	 * Any precinct/district can have an arbitrary amount of voters.
	 */
	public function precinct() {
		return $this->hasMany('Voter');
	}
}