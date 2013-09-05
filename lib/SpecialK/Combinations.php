<?php

namespace SpecialK;

/**
 * @see http://stackoverflow.com/a/3742837
 */
class Combinations implements \Iterator
{
    private
        $c = null,
        $s = null,
        $n = 0,
        $k = 0,
        $pos = 0;

    public function __construct($s, $k)
    {
        if(count($s) < $k) {
            throw new \InvalidArgumentException("List must be at least $k long");
        }

        $this->s = array_values($s);
        $this->n = count($this->s);
        $this->k = $k;
        $this->rewind();
    }

    public function key()
    {
        return $this->pos;
    }

    public function current()
    {
        $r = array();

        for($i = 0; $i < $this->k; $i++)
            $r[] = $this->s[$this->c[$i]];

        return $r;
    }

    public function next()
    {
        if($this->_next())
            $this->pos++;
        else
            $this->pos = -1;
    }

    public function rewind()
    {
        $this->c = range(0, $this->k);
        $this->pos = 0;
    }

    public function valid()
    {
        return $this->pos >= 0;
    }

    private function _next()
    {
        $i = $this->k - 1;
        while ($i >= 0 && $this->c[$i] == $this->n - $this->k + $i)
            $i--;
        if($i < 0)
            return false;
        $this->c[$i]++;
        while($i++ < $this->k - 1)
            $this->c[$i] = $this->c[$i - 1] + 1;
        return true;
    }
}
